<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => '10',
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'uom_id'      => [
                'type'       => 'INT',
                'constraint' => '10',
            ],
            'description'      => [
                'type'       => 'TEXT',
                'null' => true,
            ],
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at'  => [
                'null' => true,
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');

    }
}
