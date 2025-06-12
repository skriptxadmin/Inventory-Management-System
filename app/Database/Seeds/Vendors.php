<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Vendor;

class Vendors extends Seeder
{
    public function run()
    {
        $vendors = array(
  array('id' => '1','name' => 'Sri Veeras Creations','description' => NULL,'created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','name' => 'Tirumala Icecream','description' => 'Tirumala Icecream','created_at' => '2025-06-11 11:09:46','updated_at' => '2025-06-11 11:09:46','deleted_at' => NULL)
);


        foreach ($vendors as $vendor) {

            $row = new Vendor();

             $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($vendor[$field]);
            }

            $row->save($vendor);
        }
    }
}
