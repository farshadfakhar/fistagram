<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueuesTable extends Migration
{

    public function up()
    {
        Schema::create('queues', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('account_id');
            $table->json('queue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('queues');
    }
}
