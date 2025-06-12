<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class UsersController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $roleModel = model('Role');
        $roles = $roleModel->findAll();
        return view('users/index', compact('roles'));
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
        $role_id      = $request->getPost('role_id');


        $sortColumn = null;

        if (! empty($order)) {
            $columnIndex = $order[0]['column']; // e.g. 1
            $sortDir     = $order[0]['dir'];    // 'asc' or 'desc'

            // Get the actual column name (e.g. 'name')
            $sortColumn = $columns[$columnIndex]['data'];
        }

        $model = model('User');

        if(!empty($role_id)){

            $model = $model->where('role_id', $role_id);
        }

        if (! empty($searchValue)) {
            $model->groupStart()
      ->like('fullname', $searchValue)
      ->orLike('email', $searchValue)
      ->orLike('mobile', $searchValue)
      ->groupEnd();
        }

        $totalFiltered = $model->countAllResults(false);

        $totalRecords = $model->where('users.deleted_at', null)->countAllResults(false);

        if (! empty($sortColumn)) {
            $model = $model->orderBy($sortColumn, $sortDir);
        }

        $fields = ['id','fullname', 'email', 'mobile', 'role_id'];

        $users = $model->select($fields)->findAll($length, $start);


        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $users,
        ];

        return $this->respond($response);
    }

    public function save()
    {

        $userId = $this->request->getPost('id');
        $rules  = [
            'role_id' => 'required|is_not_unique[roles.id]',
            'fullname' => 'required|is_unique[users.fullname]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'mobile' => 'required|is_unique[users.mobile]',
            'password' => 'permit_empty'
        ];
        if ($userId) {

            $rules = [
                'role_id' => 'required|is_not_unique[roles.id]',
                'fullname' => "required|is_unique[users.fullname,id, {$userId}]",
                'email' => "required|valid_email|is_unique[users.email,id, {$userId}]",
                'mobile' => "required|is_unique[users.mobile,id, {$userId}]",
                'password' => "permit_empty",
            ];
        }

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        $model = model('User');

        $validData['id'] = $userId;

        $model->save($validData);

        if(empty($validData['password'])){

            if(empty($userId)){

                $validData['password'] = generateRandomString();
            }
        }


        return $this->respond($validData);
    }

    public function delete($id)
    {

        $model = model('User');

        $model->delete($id);

        return $this->respond(['success' => true]);

    }
}
