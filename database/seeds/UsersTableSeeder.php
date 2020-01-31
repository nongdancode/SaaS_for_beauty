<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name' => 'Hoang Le',
            'email' => 'lqhoang11394'.'@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'superadmin',
            'vendor' => 'system',
        ]);
    }
}
