<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{

    public function up()
    {
        Schema::create('activities', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('account_id');
            $table->string('activity');
            $table->string('details');
            $table->string('state');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::drop('activities');
    }
}
