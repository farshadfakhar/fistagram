<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public function crawlAccount(){
        return $this->HasOne(CrawlAccount::class);
    }

    public function queue(){
        return $this->HasOne(Queue::class);
    }
}
