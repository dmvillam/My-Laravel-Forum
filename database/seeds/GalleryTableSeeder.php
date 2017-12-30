<?php

use Illuminate\Database\Seeder;

class GalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('galleries')->insert(array(
            'title' => 'Demo Gallery',
            'desc' => 'Gallery for demonstration',
            'order' => 0,
            'child_of' => 0,
        ));
    }
}
