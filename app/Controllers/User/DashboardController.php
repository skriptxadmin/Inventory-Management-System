<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view("dashboard/index");

    }

    public function summary()
    {

        $request = service('request');

        $start = $request->getPost('start') ?? date('Y-m-d');

        $end = $request->getPost('end') ?? date('Y-m-d');

        $model = model('Purchase');

        $purchase = $model->select('SUM(total) as total, SUM(paid) as paid, SUM(balance) as balance')
            ->where('purchase_date >=', $start)
            ->where('purchase_date <=', $end)
            ->get()
            ->getRow();

        $model = model('Invoice');

        $invoice = $model->select('SUM(total) as total, SUM(paid) as paid, SUM(balance) as balance')
            ->where('invoice_date >=', $start)
            ->where('invoice_date <=', $end)
            ->get()
            ->getRow();

        return $this->respond(compact('purchase', 'invoice'));
    }

    public function stock()
    {

        $request = service('request');

        $balance     = $request->getPost('balance') ?? 10;
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

        $model = model('Stock');

        $builder = $model->db->table('stocks s')
            ->select('s.balance, p.name, uom.name as unit')
            ->join('products p', 's.product_id = p.id AND p.deleted_at IS NULL', 'left')
            ->join('unit_of_measures uom', 'p.uom_id = uom.id AND uom.deleted_at IS NULL', 'left')
            ->where('s.balance <=', $balance)
            ->where('s.deleted_at IS NULL');

        $totalRecords = $builder->countAllResults(false);
        $totalFiltered = $builder->countAllResults(false);

        if (! empty($searchValue)) {
            // Add LIKE condition on p.name
            $builder->like('p.name', $searchValue);

            $totalFiltered = $builder->like('p.name', $searchValue)->countAllResults(false);

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
}
