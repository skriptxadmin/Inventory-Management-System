<?php
namespace App\Database\Seeds;

use App\Models\Role;
use CodeIgniter\Database\Seeder;

class Roles extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
            ],
        ];

        foreach ($roles as $role) {

            $row = new Role();

            $row->save($role);
        }
    }
}
