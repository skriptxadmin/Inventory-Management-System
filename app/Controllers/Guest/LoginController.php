<?php

namespace App\Controllers\Guest;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;

use App\Models\User;


class LoginController extends BaseController
{
    use ResponseTrait;
    public function index(): RedirectResponse|string
    {
        
        return view('guest/login');
    }

    public function login(){
       
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {

            return $this->fail($this->validator->getErrors(), 422);
        }

        // If you want to get the validated data.
        $validData = (object)$this->validator->getValidated();

        $userModel = new User;

        $user = $userModel->where('email', $validData->username)
        ->orWhere('mobile', $validData->username)
        ->first();

        if(empty($user)){

           return $this->fail(['User not registered with us'], 422);
        }

        if(!password_verify($validData->password, $user->password)){

           return $this->fail(['Email/Mobile and Password does not match'], 422);

        }
        
        $session = session();

        $session->set('user', $user->email);

        return $this->respond(['success' => true, 'redirect'=> base_url('/dashboard')], 200);
    }
}
