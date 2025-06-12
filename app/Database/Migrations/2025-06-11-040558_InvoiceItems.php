<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InvoiceItems extends Migration
{
  
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'invoice_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
             'product_id'       => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
             'quantity'       => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
              'price'       => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at' => [
                'null' => true,
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('invoice_items');
    }

    public function down()
    {
        $this->forge->dropTable('invoice_items');

    }

}
