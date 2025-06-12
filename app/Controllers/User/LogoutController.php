<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LogoutController extends BaseController
{
    public function index():RedirectResponse
    {
        $session = session();

        $session->remove('user');

        $session->destroy();
        
        return redirect()->to(base_url());
    }


}
