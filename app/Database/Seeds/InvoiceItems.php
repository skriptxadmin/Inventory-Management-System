<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\InvoiceItem;

class InvoiceItems extends Seeder
{
    public function run()
    {
        $invoice_items = array(
  array('id' => '1','invoice_id' => '1','product_id' => '1','quantity' => '5','price' => '20.00','created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:08:15','deleted_at' => '2025-06-11 11:08:15'),
  array('id' => '2','invoice_id' => '1','product_id' => '1','quantity' => '3','price' => '20.00','created_at' => '2025-06-11 11:08:15','updated_at' => '2025-06-11 11:08:15','deleted_at' => NULL),
  array('id' => '3','invoice_id' => '2','product_id' => '2','quantity' => '5','price' => '15.00','created_at' => '2025-06-11 11:14:27','updated_at' => '2025-06-11 11:14:36','deleted_at' => '2025-06-11 11:14:36'),
  array('id' => '4','invoice_id' => '2','product_id' => '1','quantity' => '10','price' => '0.00','created_at' => '2025-06-11 11:14:27','updated_at' => '2025-06-11 11:14:36','deleted_at' => '2025-06-11 11:14:36'),
  array('id' => '5','invoice_id' => '2','product_id' => '2','quantity' => '5','price' => '15.00','created_at' => '2025-06-11 11:14:36','updated_at' => '2025-06-11 11:14:36','deleted_at' => NULL),
  array('id' => '6','invoice_id' => '2','product_id' => '1','quantity' => '10','price' => '0.00','created_at' => '2025-06-11 11:14:36','updated_at' => '2025-06-11 11:14:36','deleted_at' => NULL)
);

        foreach ($invoice_items as $invoiceItem) {

            $row = new InvoiceItem();

              $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($invoiceItem[$field]);
            }


            $row->save($invoiceItem);
        }
    }
}
