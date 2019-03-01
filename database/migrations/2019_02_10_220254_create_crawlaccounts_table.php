<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlaccountsTable extends Migration
{

    public function up()
    {
        Schema::create('crawlaccounts', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_id');
            $table->string('username');
            $table->boolean('active')->default(1);
            $table->string('next_page')->nullable();
            $table->boolean('error')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('crawlaccounts');
    }
}
