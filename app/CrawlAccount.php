<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CrawlAccount extends Model {

    protected $table= "crawlaccounts";

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
