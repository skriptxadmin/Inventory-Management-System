<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
              'role_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true

            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at' => [
                'null' => true,
                'type' => 'datetime'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
        
    }
}
