<?php
namespace App\Database\Seeds;

use App\Models\Invoice;
use CodeIgniter\Database\Seeder;

class Invoices extends Seeder
{
    public function run()
    {
        $invoices = [
            ['id' => '1', 'invoice_no' => 'xyz-1234', 'invoice_date' => '2025-06-10', 'outlet_id' => '1', 'customer_id' => '1', 'subtotal' => '60.00', 'taxes' => '5.00', 'discount' => '10.00', 'total' => '55.00', 'description' => 'tsting', 'created_at' => '2025-06-11 11:01:47', 'updated_at' => '2025-06-11 11:08:15', 'deleted_at' => null],
            ['id' => '2', 'invoice_no' => 'g123', 'invoice_date' => '2025-06-04', 'outlet_id' => '1', 'customer_id' => '2', 'subtotal' => '75.00', 'taxes' => '10.00', 'discount' => '0.00', 'total' => '85.00', 'description' => '', 'created_at' => '2025-06-11 11:14:27', 'updated_at' => '2025-06-11 11:14:36', 'deleted_at' => null],
        ];

        foreach ($invoices as $invoice) {

            $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach ($unsetfields as $field) {

                unset($invoice[$field]);
            }

            $row = new Invoice();

            $row->save($invoice);
        }
    }
}
