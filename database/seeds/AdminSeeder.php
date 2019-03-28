<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            // 'email' => Str::random(10).'@admin.com',
            'email' => 'admin2@admin.com',
            // 'password' => bcrypt('secret'),
            'password' => '123456',
            'profile_img' => ' ',
            'role_id' => '0',
            'role_type' => 'admin',
            ]);
    }
}
