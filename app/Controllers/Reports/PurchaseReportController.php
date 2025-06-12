<?php
namespace App\Controllers\Reports;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class PurchaseReportController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model   = model('Outlet');
        $outlets = $model->findAll();
        return view('reports/purchase/index', compact('outlets'));
    }

    public function list()
    {

        $request     = service('request');
        $draw        = $request->getPost('draw');
        $start       = $request->getPost('start');
        $length      = $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? null;

        $vendorId  = $request->getPost('vendorId') ?? null;
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

        $model = model('Purchase');

        

        

        $builder = $model->db->table('purchases pr')
            ->select('pr.purchase_date, pr.purchase_no,  pi.product_id as product_id, pi.quantity, pi.price, p.name as product_name, uom.name as unit')
            ->groupStart()
            ->where('pr.purchase_date >=', $duration[0])
            ->where('pr.purchase_date <=', $duration[1])
            ->groupEnd()
            ->join('purchase_items pi', 'pi.purchase_id = pr.id AND pi.deleted_at IS NULL', 'left')
            ->join('products p', 'p.id = pi.product_id AND p.deleted_at IS NULL', 'left')
            ->join('unit_of_measures uom', 'uom.id = p.uom_id AND uom.deleted_at IS NULL', 'left')
            ->where('pr.deleted_at IS NULL');

            $totalRecords = $builder->countAllResults(false);

             if($vendorId){

            $builder = $builder->where('pr.vendor_id', $vendorId);
        }
            
        if(!empty($productId) && count($productId)){

            $builder = $builder->whereIn('pi.product_id', $productId);
        }

    
        $totalFiltered = $builder->countAllResults(false);
        $purchases = $builder->limit($length, $start)->get()->getResult();

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $purchases,
        ];

        return $this->respond($response);
    }
}
