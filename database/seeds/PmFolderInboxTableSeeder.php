<?php

use Illuminate\Database\Seeder;

class PmFolderInboxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pm_folders')->insert(array(
            'folder_name' => 'Inbox',
            'folder_desc' => 'Bandeja de Entrada',
            'user_id' => 0,
        ));
    }
}
