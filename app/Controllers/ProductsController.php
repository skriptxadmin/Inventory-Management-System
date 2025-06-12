<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ProductsController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $uomModel = model('UnitOfMeasure');

        $uoms = $uomModel->findAll();
        return view('products/index', compact('uoms'));
    }

    public function select2()
    {

        $request = service('request');
        $q       = $request->getPost('q') ?? '';

        $model = model('Product');

        $builder = $model->db->table('products');
        if ($q) {

            $builder = $builder->like('products.name', $q);
        }

        $products = $builder->select([
            'products.id',
            'products.name as product_name',
            'uom.name as uom_name',
        ])
            ->join('unit_of_measures uom', 'uom.id = products.uom_id AND uom.deleted_at IS NULL', 'left')
            ->limit(10, 0)
            ->get()
            ->getResult();

        return $this->respond($products);
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
            ->select('p.id, p.name, p.description, c.id AS category_id, c.name AS category_name, u.id AS uom_id, u.name AS uom_name')
            ->join('categories c', 'c.id = p.category_id AND c.deleted_at IS NULL', 'left')
            ->join('unit_of_measures u', 'u.id = p.uom_id AND u.deleted_at IS NULL', 'left')
            ->where('p.deleted_at IS NULL');

        if (! empty($searchValue)) {
            // Add LIKE condition on p.name
            $builder->like('p.name', $searchValue);
        }
        if (! empty($sortColumn)) {
            $builder->orderBy($sortColumn, $sortDir);
        }

        $rawResults = $builder
            ->limit($length, $start)
            ->get()
            ->getResult();

        $products = array_map(function ($row) {
            return [
                'id'          => $row->id,
                'name'        => $row->name,
                'description' => $row->description,
                'category'    => [
                    'id'   => $row->category_id,
                    'name' => $row->category_name,
                ],
                'uom'         => [
                    'id'   => $row->uom_id,
                    'name' => $row->uom_name,
                ],
            ];
        }, $rawResults);

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $products,
        ];

        return $this->respond($response);
    }

    public function save()
    {

        $productId = $this->request->getPost('id');
        $rules     = [
            'name'        => 'required|is_unique[products.name]',
            'category_id' => 'required',
            'uom_id'      => 'required',
            'description' => 'permit_empty',
        ];
        if ($productId) {

            $rules = [
                'name'        => "required|is_unique[products.name,id,{$productId}]",
                'category_id' => 'required',
                'uom_id'      => 'required',
                'description' => 'permit_empty',
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('Product');

        $validData['id'] = $productId;

        $model->save($validData);

        return $this->respond($validData);
    }

    public function delete($id)
    {

        $model = model('Product');

        $model->delete($id);

        return $this->respond(['success' => true]);

    }
}
