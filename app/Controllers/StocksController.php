<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class StocksController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('stocks/index');
    }
    public function list()
    {

        $request     = service('request');
        $draw        = $request->getPost('draw');
        $start       = $request->getPost('start');
        $length      = $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? null;

        // Get sorting info
        $order   = $request->getPost('order');
        $columns = $request->getPost('columns');

        $sortColumn = null;

        if (! empty($order)) {
            $columnIndex = $order[0]['column']; // e.g. 1
            $sortDir     = $order[0]['dir'];    // 'asc' or 'desc'

            // Get the actual column name (e.g. 'name')
            $sortColumn = $columns[$columnIndex]['data'];
        }

        $model = model('Product');

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('deleted_at', null)->countAllResults(false);

        $builder = $model->db->table('products p')
            ->select('p.id, p.name, p.description, c.id AS category_id, c.name AS category_name, u.id AS uom_id, u.name AS uom_name, s.purchased, s.invoiced, s.balance')
            ->join('categories c', 'c.id = p.category_id AND c.deleted_at IS NULL', 'left')
            ->join('unit_of_measures u', 'u.id = p.uom_id AND u.deleted_at IS NULL', 'left')
            ->join('stocks s', 's.product_id = p.id AND s.deleted_at IS NULL', 'left')
            ->where('p.deleted_at IS NULL');

        if (! empty($searchValue)) {
            // Add LIKE condition on p.name
            $builder->like('p.name', $searchValue);
        }
        if (! empty($sortColumn)) {
            $builder->orderBy($sortColumn, $sortDir);
        }

        $products = $builder
            ->limit($length, $start)
            ->get()
            ->getResult();

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $products,
        ];

        return $this->respond($response);
    }

    public function calculate()
    {

        helper('calculate_stock');
        calculate_stock([]);
        return $this->respond(['success'=> true]);
    }
}
