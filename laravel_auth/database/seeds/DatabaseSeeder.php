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
        // [OAUTH] Appel seeder création user
        $this->call(UsersTableSeeder::class);
    }
}
