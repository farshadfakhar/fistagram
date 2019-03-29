<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function queue(){
        return $this->hasMany(Queue::class);
    }

    public function crawlAccount(){
        return $this->hasOne(CrawlAccount::class);
    }

    public function scopeFollowMode($query)
    {
        return $query->where('mode',1);
    }

    public function scopeUnFollowMode($query)
    {
        return $query->where('mode',2);
    }

    public function scopeActive($query)
    {
        return $query->where('active',1)->where('insta_error', 0);
    }
}
