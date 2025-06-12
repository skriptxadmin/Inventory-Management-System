<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Outlet;

class Outlets extends Seeder
{
    public function run()
    {
        $outlets = [
            [
                'name' => 'Crazy Collection',
            ],
             
        ];

        foreach ($outlets as $outlet) {

            $row = new Outlet();

            $row->save($outlet);
        }
    }
}
