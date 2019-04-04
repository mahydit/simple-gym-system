<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'profile_img' => ' ',
            'role_id' => '0',
            'role_type' => 'admin',
            ])->assignRole('admin');
            $this->command->info("User created successfully!");
    }
}
