<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Customer;

class Customers extends Seeder
{
    public function run()
    {
       $customers = array(
  array('id' => '1','name' => 'Mangala','description' => NULL,'created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','name' => 'Getsy','description' => 'dummy customer','created_at' => '2025-06-11 11:09:30','updated_at' => '2025-06-11 11:09:30','deleted_at' => NULL)
);

        foreach ($customers as $customer) {

            
            $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($customer[$field]);
            }

            $row = new Customer();

            $row->save($customer);
        }
    }
}
