<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class PurchasesController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('purchases/list/index');
    }

    public function form($id = null)
    {
        return view('purchases/form/index', compact('id'));
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

        $model = model('Purchase');

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('deleted_at', null)->countAllResults(false);

        $builder = $model->db->table('purchases p')
            ->select('p.id, p.vendor_id, p.purchase_no, p.purchase_date, p.subtotal, p.taxes, p.discount,p.total, p.paid, p.balance,  v.name AS vendor_name')
            ->join('vendors v', 'v.id = p.vendor_id AND v.deleted_at IS NULL', 'left')
            ->where('p.deleted_at IS NULL');

        if (! empty($searchValue)) {
            // Add LIKE condition on p.name
            $builder->like('p.purchase_no', $searchValue)
            ->orLike('v.name', $searchValue);

            $totalFiltered = $builder->like('purchase_no', $searchValue)
            ->orLike('v.name', $searchValue)->countAllResults(false);

        }
        if (! empty($sortColumn)) {
            $builder->orderBy($sortColumn, $sortDir);
        }

        $purchases = $builder
            ->limit($length, $start)
            ->get()
            ->getResult();

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $purchases,
        ];

        return $this->respond($response);
    }

    public function get($id)
    {

        $model = model('Purchase');

        $row = $model->db->table('purchases p')
            ->select('p.id, p.vendor_id, p.purchase_no, p.purchase_date, p.subtotal, p.taxes, p.description, p.discount,p.total, p.paid, p.balance, v.id AS vendor_id, v.name AS vendor_name')
            ->join('vendors v', 'v.id = p.vendor_id AND v.deleted_at IS NULL', 'left')
            ->where('p.id', $id)
            ->where('p.deleted_at', null)
            ->get()
            ->getRow();

        if (empty($row)) {

            return $this->fail(['Purchase order is invalid'], 422);
        }

        $itemsModel = model('PurchaseItem');
        $row->items = $itemsModel->db->table('purchase_items pi')
            ->select('pi.product_id, pi.quantity, pi.price, pr.name as product_name, pr.uom_id, u.name as unit')
            ->join('products pr', 'pr.id = pi.product_id AND pr.deleted_at IS NULL', 'left')
            ->join('unit_of_measures u', 'u.id = pr.uom_id AND u.deleted_at IS NULL', 'left')
            ->where('pi.purchase_id', $row->id)
            ->where('pi.deleted_at', null)
            ->get()
            ->getResult();

        return $this->respond($row);
    }
    public function save()
    {
        $purchaseId = $this->request->getPost('id');
        $rules      = [
            'id'            => 'permit_empty|integer',
            'vendor_id'     => 'required|integer',
            // 'items'              => 'required|is_array|min_length[1]',
            // 'items.*.product_id' => 'required|is_not_unique[products.id]',
            // 'items.*.quantity'   => 'required|decimal',
            // 'items.*.price'      => 'required|decimal',
            'subtotal'      => 'required|decimal',
            'taxes'         => 'required|decimal',
            'discount'      => 'required|decimal',
            'total'         => 'required|decimal',
            'paid'         => 'required|decimal',
            'balance'         => 'required|decimal',
            'purchase_no'   => 'required|string|is_unique[purchases.purchase_no]',
            'purchase_date' => 'required|valid_date[Y-m-d]',
            'description'   => 'permit_empty',
        ];
        if ($purchaseId) {

            $rules = [
                'id'            => 'permit_empty|integer|is_not_unique[purchases.id]',
                'vendor_id'     => 'required|integer',
                // 'items'              => 'required|is_array|min_length[1]',
                // 'items.*.product_id' => 'required|is_not_unique[products.id]',
                // 'items.*.quantity'   => 'required|decimal',
                // 'items.*.price'      => 'required|decimal',
                'subtotal'      => 'required|decimal',
                'taxes'         => 'required|decimal',
                'discount'      => 'required|decimal',
                'total'         => 'required|decimal',
                 'paid'         => 'required|decimal',
            'balance'         => 'required|decimal',
                'purchase_no'   => "required|string|is_unique[purchases.purchase_no,id,{$purchaseId}]",
                'purchase_date' => 'required|valid_date[Y-m-d]',
                'description'   => 'permit_empty',
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('Purchase');

        $validData['id'] = $purchaseId;

        $ret = $model->save($validData);

        $purchase_id = empty($purchaseId) ? $model->db->insertID() : $purchaseId;

        $items = $this->request->getPost('items');

        $itemsModel = model('PurchaseItem');

        $itemsModel->where('purchase_id', $purchase_id)->delete();


        foreach ($items as $item) {
            $item['purchase_id'] = $purchase_id;
            $itemsModel->save($item);
        }
        
        $product_ids = array_column($items, 'product_id');
        helper('calculate_stock');
        calculate_stock($product_ids);

        return $this->respond(['success' => true]);

    }

    public function delete($id)
    {

        $model = model('Purchase');

        $model->delete($id);

        $model = model('PurchaseItem');

        $model->where('purchase_id', $id)->delete();

        return $this->respond(['success' => true]);

    }
}
