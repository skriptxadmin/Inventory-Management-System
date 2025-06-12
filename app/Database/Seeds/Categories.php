<?php
namespace App\Database\Seeds;

use App\Models\Category;
use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categories = array(
  array('id' => '1','parent_id' => NULL,'name' => 'Icecream','created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '2','parent_id' => '1','name' => 'Cone Ice','created_at' => '2025-06-11 11:01:47','updated_at' => '2025-06-11 11:01:47','deleted_at' => NULL),
  array('id' => '3','parent_id' => '1','name' => 'Cup','created_at' => '2025-06-11 11:08:58','updated_at' => '2025-06-11 11:08:58','deleted_at' => NULL)
);



        foreach ($categories as $category) {

            $unsetfields = ['id', 'created_at', 'updated_at', 'deleted_at'];

            foreach($unsetfields as $field){

                unset($category[$field]);
            }

            $row = new Category();

            $row->save($category);
        }
    }
}
