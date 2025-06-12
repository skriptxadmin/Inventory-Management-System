<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitOfMeasure extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
              
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at' => [
                'null' => true,
                'type' => 'datetime'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('unit_of_measures');
    }

    public function down()
    {
                $this->forge->dropTable('unit_of_measures');
        
    }
}
