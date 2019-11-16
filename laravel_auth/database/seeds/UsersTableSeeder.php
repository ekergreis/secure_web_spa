<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // [OAUTH] Appel factory User pour création de 10 comptes
        factory(User::class, 10)->create();
    }
}
