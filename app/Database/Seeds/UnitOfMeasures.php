<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UnitOfMeasure;

class UnitOfMeasures extends Seeder
{
    public function run()
    {
         $measures = [
            [
                'name' => 'Meter',
            ],
             [
                'name' => 'Kilogram',
            ],
            [
                'name' => 'Each',
            ],
        ];

        foreach ($measures as $measure) {

            $row = new UnitOfMeasure();

            $row->save($measure);
        }
    }
}
