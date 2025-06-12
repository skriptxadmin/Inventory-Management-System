<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\User;

class Users extends Seeder
{
    public function run()
    {
         $users = [
            [
                'fullname' => 'Administrator',
                'role_id'=> 1,
                'email' => 'administrator@example.com',
                'mobile' => '9042013581',
                'password' =>  'Password@123'
            ]
            ];

            foreach($users as $user){

                $newUser = new User();

                $newUser->save($user);
            }
    }
    
}
