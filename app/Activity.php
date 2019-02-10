<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $fillable = [];

    protected $dates = [];

    protected $table = 'activities';

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
