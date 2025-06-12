<?php 

function is_user_logged_in(){

    $session = session();

    return $session->has('user');
}