<?php 

use App\Models\User;

function get_current_app_user(){

    $session = session();

    if(empty($session->has('user'))){

        return false;
    }

    $userObj = new User;

    $user = $userObj->where('email', $session->get('user'))->first();

    if(empty($user)){

        return false;
    }
    return $user;
}