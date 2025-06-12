<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stocks extends Migration
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
            'product_id' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'purchased'  => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'invoiced'   => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
            ],
            'balance'    => [
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
        $this->forge->createTable('stocks');
    }

    public function down()
    {
        $this->forge->dropTable('stocks');

    }

}
