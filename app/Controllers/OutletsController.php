<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class OutletsController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('outlets/index');
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

        $model = model('Outlet');

        if (! empty($searchValue)) {
            $model->like('name', $searchValue);
        }

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('deleted_at', null)->countAllResults(false);

        if (! empty($sortColumn)) {
            $model = $model->orderBy($sortColumn, $sortDir);
        }

        $roles = $model->select(['id', 'name','description'])
        ->findAll($length, $start);

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $roles,
        ];

        return $this->respond($response);
    }

    public function save()
    {

        $outletId = $this->request->getPost('id');
        $rules  = [
            'name' => 'required|is_unique[outlets.name]',
            'description' =>'permit_empty'
        ];
        if ($outletId) {

            $rules = [
                'name' => "required|is_unique[outlets.name,id,{$outletId}]",
                'description' =>'permit_empty'
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('Outlet');

        $validData['id'] = $outletId;

        $model->save($validData);

        return $this->respond($validData);
    }

    public function delete($id)
    {

        $model = model('Outlet');

        $model->delete($id);

        return $this->respond(['success' => true]);

    }
}
