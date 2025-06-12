<?php
namespace App\Controllers\Reports;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class SalesReportController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model   = model('Outlet');
        $outlets = $model->findAll();
        return view('reports/sales/index', compact('outlets'));
    }

    public function list()
    {

        $request     = service('request');
        $draw        = $request->getPost('draw');
        $start       = $request->getPost('start');
        $length      = $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? null;

        $outletId  = $request->getPost('outletId') ?? null;
        $customerId  = $request->getPost('customerId') ?? null;
        $productId = $request->getPost('productId') ?? null;
        $duration  = $request->getPost('duration') ?? null;

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

        $model = model('Invoice');

        

        

        $builder = $model->db->table('invoices i')
            ->select('i.invoice_date, i.invoice_no, i.outlet_id, ii.product_id as product_id, ii.quantity, ii.price, p.name as product_name, uom.name as unit')
            ->groupStart()
            ->where('invoice_date >=', $duration[0])
            ->where('invoice_date <=', $duration[1])
            ->groupEnd()
            ->join('invoice_items ii', 'ii.invoice_id = i.id AND ii.deleted_at IS NULL', 'left')
            ->join('products p', 'p.id = ii.product_id AND p.deleted_at IS NULL', 'left')
            ->join('unit_of_measures uom', 'uom.id = p.uom_id AND uom.deleted_at IS NULL', 'left')
            ->where('i.deleted_at IS NULL');

            $totalRecords = $builder->countAllResults(false);
            
        if(!empty($productId) && count($productId)){

            $builder = $builder->whereIn('ii.product_id', $productId);
        }

        if($outletId){

            $builder = $builder->where('i.outlet_id', $outletId);
        }
        if($customerId){

            $builder = $builder->where('i.customer_id', $customerId);
        }
        $totalFiltered = $builder->countAllResults(false);
        $invoices = $builder->limit($length, $start)->get()->getResult();

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $invoices,
        ];

        return $this->respond($response);
    }
}
