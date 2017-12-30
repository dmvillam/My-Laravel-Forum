<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        $folder_name = 'Inbox';
        $folder_desc = 'Bandeja de Entrada';

        /*
         * Admin account
         */
        $id = \DB::table('users')->insertGetId(array(
            'firstname'  => 'admin',
            'lastname'   => 'account',
            'fullname'   => 'admin account',
            'nickname'   => 'Admin',
            'email'      => 'admin@mylaravelforum.net',
            'password'   => \Hash::make('admin'),
            'type'       => 'admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ));

        \DB::table('user_profiles')->insert(array(
            'user_id'    => $id,
            'bio'        => '',
            'website'    => 'mylaravelforum.org',
            'birthdate'  => '2004/01/08',
            'twitter'    => 'http://www.twitter.com/mylaravelforum',
            'country_id' => array_search('Venezuela', config('countries.list')) + 1,
            'avatar' => ''
        ));

        \DB::table('pm_folders')->insert(array(
            'user_id'     => $id,
            'folder_name' => $folder_name,
            'folder_desc' => $folder_desc,
        ));

        /*
         * User account
         */
        $id = \DB::table('users')->insertGetId(array(
            'firstname'  => 'user',
            'lastname'   => 'account',
            'fullname'   => 'user account',
            'nickname'   => 'User Test',
            'email'      => 'user_test@mylaravelforum.net',
            'password'   => \Hash::make('user'),
            'type'       => 'user',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ));

        \DB::table('user_profiles')->insert(array(
            'user_id'    => $id,
            'bio'        => 'Here goes my bio.',
            'website'    => '',
            'birthdate'  => '1994/01/08',
            'twitter'    => '',
            'country_id' => array_search('Venezuela', config('countries.list')) + 1,
            'avatar' => ''
        ));

        \DB::table('pm_folders')->insert(array(
            'user_id'     => $id,
            'folder_name' => $folder_name,
            'folder_desc' => $folder_desc,
        ));
    }
}
