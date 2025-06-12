<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class CategoryController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('categories/index');
    }

    public function select2(){

          $request     = service('request');
        $q        = $request->getPost('q') ?? '';

        $model = model('Category');

        if($q){

        $model = $model->like('name', $q);
        }

        $categories = $model->select(['id', 'name'])->findAll(0, 10);

        return $this->respond($categories);
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

        $model = model('Category');

        if (! empty($searchValue)) {
            $model->like('name', $searchValue);
        }

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('deleted_at', null)->countAllResults(false);

        if (! empty($sortColumn)) {
            $model = $model->orderBy($sortColumn, $sortDir);
        }

        $categories = $model->select(['id', 'parent_id', 'name'])
        ->findAll($length, $start);

        foreach($categories as $category){
            
            $model = model('Category');

            $category->parent = NULL;

            if(!empty($category->parent_id)){

                $category->parent = $model->select(['id', 'name'])->find($category->parent_id);
            }
        }

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $categories,
        ];

        return $this->respond($response);
    }

    public function save()
    {

        $categoryId = $this->request->getPost('id');
        $rules  = [
            'name' => 'required|is_unique[categories.name]',
            'parent_id' => 'permit_empty'
        ];
        if ($categoryId) {

            $rules = [
                'name' => "required|is_unique[categories.name,id,{$categoryId}]",
            'parent_id' => 'permit_empty'

            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('Category');

        $validData['id'] = $categoryId;

        $model->save($validData);

        return $this->respond($validData);
    }

    public function delete($id)
    {

        $model = model('Category');

        // TODO: restrict category deletion based on product count
     
        $model->delete($id);

        return $this->respond(['success' => true]);

    }
}
