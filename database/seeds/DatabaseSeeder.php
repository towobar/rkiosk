<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        User::create([
            'name' => 'Anton',
            'email' => 'anton@freenet.de',
            'password' => 'anton',
        ]);



        User::create([
            'name' => 'Bertha',
            'email' => 'bertha@freenet.de',
            'password' => 'bertha',
        ]);

        User::create([
            'name' => 'Curt',
            'email' => 'curt@freenet.de',
            'password' => 'curt',
        ]);


    }
}
