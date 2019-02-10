<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlaccountsTable extends Migration
{

    public function up()
    {
        Schema::create('crawlaccounts', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('account_id');
            $table->string('username');
            $table->boolean('active');
            $table->string('next_page');
            $table->boolean('error');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('crawlaccounts');
    }
}
