<?php

use Illuminate\Database\Seeder;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_id = \DB::table('categories')->insertGetId(array(
            'name' => 'Demo Category',
            'order' => 0,
        ));

        \DB::table('boards')->insert(array(
            'name' => 'Demo Board',
            'desc' => 'Board for demo',
            'order' => 0,
            'category_id' => $category_id,
        ));
    }
}
