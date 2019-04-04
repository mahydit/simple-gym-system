<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CountriesSeeder');
        $this->command->info('Seeded the countries!');

        $this->call('RolesAndPermissionsSeeder');
        $this->command->info('Seeded Roles and Permissions!');
    }
}
