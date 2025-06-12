<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Purchase;

class Purchases extends Seeder
{
    public function run()
    {
        $purchases = array(
  array('id' => '1','purchase_no' => 'abcd-1234','purchase_date' => '2025-06-10','vendor_id' => '1','subtotal' => '300.00','taxes' => '0.00','discount' => '0.00','total' => '300.00','description' => NULL,'created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','purchase_no' => 't12345','purchase_date' => '2025-06-02','vendor_id' => '2','subtotal' => '2300.00','taxes' => '15.00','discount' => '-5.00','total' => '2320.00','description' => '','created_at' => '2025-06-11 11:10:46','updated_at' => '2025-06-11 11:11:33','deleted_at' => NULL)
);
        foreach ($purchases as $purchase) {

            $row = new Purchase();

               $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($purchase[$field]);
            }


            $row->save($purchase);
        }
    }
}
