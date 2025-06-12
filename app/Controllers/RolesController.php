<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class RolesController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('roles/index');
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

        $model = model('Role');

        if (! empty($searchValue)) {
            $model->like('name', $searchValue);
        }

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('roles.deleted_at', null)->countAllResults(false);

        if (! empty($sortColumn)) {
            $model = $model->orderBy($sortColumn, $sortDir);
        }

        $roles = $model->select('roles.id, roles.name, COUNT(users.id) as userCount')
        ->join('users', 'users.role_id = roles.id AND users.deleted_at IS NULL', 'left')
          ->where('roles.deleted_at', null)  // specify table here
        ->groupBy('roles.id')
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

        $roleId = $this->request->getPost('id');
        $rules  = [
            'name' => 'required|is_unique[roles.name]',
        ];
        if ($roleId) {

            $rules = [
                'name' => "required|is_unique[roles.name,id,{$roleId}]",
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('Role');

        $validData['id'] = $roleId;

        $model->save($validData);

        return $this->respond($validData);
    }

    public function delete($id)
    {

        $model = model('Role');

        $userModel = model('User');

        $count = $userModel->where('role_id', $id)->countAllResults(false);

        if ($count) {

            return $this->fail(['Users attached to this role. Could not delete'], 422);

        }

        $model->delete($id);

        return $this->respond(['success' => true]);

    }
}
