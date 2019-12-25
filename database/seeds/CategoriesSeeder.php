<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<16; $i++) {
            $category = new \App\Category();
            $data= ['name'=>'name'.$i,'slug'=>'slug'.$i];
            $category->fill($data);
            $category->save();
        }
    }
}
