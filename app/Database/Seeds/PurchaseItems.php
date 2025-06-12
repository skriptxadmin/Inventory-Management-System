<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PurchaseItem;

class PurchaseItems extends Seeder
{
    public function run()
    {
        $purchase_items = array(
  array('id' => '1','purchase_id' => '1','product_id' => '1','quantity' => '20','price' => '15.00','created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','purchase_id' => '2','product_id' => '2','quantity' => '100','price' => '12.00','created_at' => '2025-06-11 11:10:46','updated_at' => '2025-06-11 11:11:33','deleted_at' => '2025-06-11 11:11:33'),
  array('id' => '3','purchase_id' => '2','product_id' => '1','quantity' => '50','price' => '10.00','created_at' => '2025-06-11 11:10:46','updated_at' => '2025-06-11 11:11:33','deleted_at' => '2025-06-11 11:11:33'),
  array('id' => '4','purchase_id' => '2','product_id' => '2','quantity' => '100','price' => '12.00','created_at' => '2025-06-11 11:11:33','updated_at' => '2025-06-11 11:11:33','deleted_at' => NULL),
  array('id' => '5','purchase_id' => '2','product_id' => '1','quantity' => '50','price' => '10.00','created_at' => '2025-06-11 11:11:33','updated_at' => '2025-06-11 11:11:33','deleted_at' => NULL),
  array('id' => '6','purchase_id' => '2','product_id' => '2','quantity' => '50','price' => '12.00','created_at' => '2025-06-11 11:11:33','updated_at' => '2025-06-11 11:11:33','deleted_at' => NULL)
);

        foreach ($purchase_items as $purchaseItem) {

            $row = new PurchaseItem();

              $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($purchaseItem[$field]);
            }

            $row->save($purchaseItem);
        }
    }
}
