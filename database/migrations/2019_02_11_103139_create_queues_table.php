<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueuesTable extends Migration
{

    public function up()
    {
        Schema::create('queues', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_id');
            $table->json('queue')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('queues');
    }
}
