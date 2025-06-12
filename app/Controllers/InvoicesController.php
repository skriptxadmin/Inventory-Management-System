<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class InvoicesController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('invoices/list/index');
    }

    public function form($id = null)
    {
        $outletModel = model('Outlet');
        $outlets = $outletModel->findAll();
        return view('invoices/form/index', compact('id', 'outlets'));
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

        $model = model('Invoice');

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('deleted_at', null)->countAllResults(false);

        $builder = $model->db->table('invoices i')
            ->select('i.id, i.outlet_id, i.customer_id, i.invoice_no, i.invoice_date, i.subtotal, i.taxes, i.discount,i.total, i.paid, i.balance, c.name AS customer_name, o.name AS outlet_name')
            ->join('customers c', 'c.id = i.customer_id AND c.deleted_at IS NULL', 'left')
            ->join('outlets o', 'o.id = i.outlet_id AND o.deleted_at IS NULL', 'left')
            ->where('i.deleted_at IS NULL');

        if (! empty($searchValue)) {
            // Add LIKE condition on p.name
            $builder->like('i.invoice_no', $searchValue)->orLike('c.name', $searchValue);

            $totalFiltered = $builder->like('i.invoice_no', $searchValue)
                            ->orLike('c.name', $searchValue)->countAllResults(false);

        }
        if (! empty($sortColumn)) {
            $builder->orderBy($sortColumn, $sortDir);
        }

        $invoices = $builder
            ->limit($length, $start)
            ->get()
            ->getResult();

      

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $invoices,
        ];

        return $this->respond($response);
    }

    public function get($id){

        $model = model('Invoice');

        $row = $model->db->table('invoices i')
             ->select('i.id, i.outlet_id, i.customer_id, i.invoice_no, i.invoice_date, i.subtotal, i.taxes, i.discount,i.total, i.paid, i.balance, i.description, c.name AS customer_name, o.name AS outlet_name')
            ->join('customers c', 'c.id = i.customer_id AND c.deleted_at IS NULL', 'left')
            ->join('outlets o', 'o.id = i.outlet_id AND o.deleted_at IS NULL', 'left')
             ->where('i.id', $id)
            ->where('i.deleted_at', null)
            ->get()
            ->getRow();

         if(empty($row)){

           return $this->fail(['Invoice order is invalid'], 422);
        }

        $itemsModel = model('InvoiceItem');
        $row->items = $itemsModel->db->table('invoice_items ii')
                    ->select('ii.product_id, ii.quantity, ii.price, pr.name as product_name, pr.uom_id, u.name as unit')
                    ->join('products pr', 'pr.id = ii.product_id AND pr.deleted_at IS NULL', 'left')
                    ->join('unit_of_measures u', 'u.id = pr.uom_id AND u.deleted_at IS NULL', 'left')
                    ->where('ii.invoice_id', $row->id)
                    ->where('ii.deleted_at', null)
                    ->get()
                    ->getResult();


       return $this->respond($row);
    }
    public function save()
    {
        $invoiceId = $this->request->getPost('id');
        $rules      = [
            'id'                 => 'permit_empty|integer',
            'customer_id'          => 'required|integer',
            'outlet_id'          => 'required|integer',
            // 'items'              => 'required|is_array|min_length[1]',
            // 'items.*.product_id' => 'required|is_not_unique[products.id]',
            // 'items.*.quantity'   => 'required|decimal',
            // 'items.*.price'      => 'required|decimal',
            'subtotal'           => 'required|decimal',
            'taxes'              => 'required|decimal',
            'discount'           => 'required|decimal',
            'total'              => 'required|decimal',
             'paid'         => 'required|decimal',
            'balance'         => 'required|decimal',
            'invoice_no'        => 'required|string|is_unique[invoices.invoice_no]',
            'invoice_date'      => 'required|valid_date[Y-m-d]',
            'description'        => 'permit_empty',
        ];
        if ($invoiceId) {

            $rules = [
                'id'                 => 'permit_empty|integer|is_not_unique[invoices.id]',
                       'customer_id'          => 'required|integer',
            'outlet_id'          => 'required|integer',
                // 'items'              => 'required|is_array|min_length[1]',
                // 'items.*.product_id' => 'required|is_not_unique[products.id]',
                // 'items.*.quantity'   => 'required|decimal',
                // 'items.*.price'      => 'required|decimal',
                'subtotal'           => 'required|decimal',
                'taxes'              => 'required|decimal',
                'discount'           => 'required|decimal',
                'total'              => 'required|decimal',
                 'paid'         => 'required|decimal',
            'balance'         => 'required|decimal',
                'invoice_no'        => "required|string|is_unique[invoices.invoice_no,id,{$invoiceId}]",
                'invoice_date'      => 'required|valid_date[Y-m-d]',
                'description'        => 'permit_empty',
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

         $model = model('Invoice');         

        $validData['id'] = $invoiceId;

        $ret = $model->save($validData);

        $invoice_id = empty($invoiceId)?$model->db->insertID():$invoiceId;

        $items = $this->request->getPost('items');

        $itemsModel = model('InvoiceItem');

        $itemsModel->where('invoice_id', $invoice_id)->delete();

        foreach($items as $item){
            $item['invoice_id'] = $invoice_id;
            $itemsModel->save($item);
        }

          $product_ids = array_column($items, 'product_id');
        helper('calculate_stock');
        calculate_stock($product_ids);
        
        return $this->respond(['success' => true]);


    }

     public function delete($id)
    {

        $model = model('Invoice');

        $model->delete($id);

        $model = model('InvoiceItem');

        $model->where('invoice_id', $id)->delete();

        return $this->respond(['success' => true]);

    }
}
