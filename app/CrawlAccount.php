<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CrawlAccount extends Model {

    protected $table= "crawlaccounts";

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
