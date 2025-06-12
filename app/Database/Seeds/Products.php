<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Product;

class Products extends Seeder
{
    public function run()
    {
        
         $products = array(
  array('id' => '1','category_id' => '2','name' => 'Chocolate Minicone','uom_id' => '3','description' => NULL,'created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','category_id' => '3','name' => 'Vanilla Cup','uom_id' => '3','description' => 'Cup Icecream','created_at' => '2025-06-11 11:09:17','updated_at' => '2025-06-11 11:09:17','deleted_at' => NULL)
);


        foreach ($products as $product) {

            $row = new Product();

             $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($product[$field]);
            }


            $row->save($product);
        }
    }
}
