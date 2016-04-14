<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
