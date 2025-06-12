<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IndexSeeder extends Seeder
{
    public function run()
    {
        $this->call('Users');
        $this->call('Roles');
        $this->call('UnitOfMeasures');
        $this->call('Categories');
        $this->call('Products');
        $this->call('Outlets');
        $this->call('Customers');
        $this->call('Vendors');
        $this->call('Purchases');
        $this->call('PurchaseItems');
        $this->call('Invoices');
        $this->call('InvoiceItems');
    }
}
