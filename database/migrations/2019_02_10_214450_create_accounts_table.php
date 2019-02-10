<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{

    public function up()
    {
        Schema::create('accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_id');
            $table->boolean('active')->default(0);
            $table->string('username');
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('accounts');
    }
}
