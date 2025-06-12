<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invoices extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice_no'   => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'invoice_date' => [
                'type' => 'DATE',
            ],
            'outlet_id'     => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'customer_id'     => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'subtotal'      => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'taxes'         => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'discount'      => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'total'         => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
             'paid'         => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
             'balance'         => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'description'   => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at'    => [
                'null' => true,
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('invoices');
    }

    public function down()
    {
        $this->forge->dropTable('invoices');

    }
}
