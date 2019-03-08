<?php

namespace App\Http\Controllers;
use InstagramAPI\Instagram;
use InstagramAPI\Signatures;
use App\User;
use App\Queue;

use App\Http\Services\InstagramService;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Activity;

class Controller extends BaseController
{
    // protected $service;


    public function __construct(InstagramService $service)
    {
        $this->service = $service;
    }

    public function login()
    {
        return Activity::orderBy('created_at','desc')->get();
        // return $this->service->startBot();
        // return User::all()->map(function($user){
        //     $instagram = $this->service->login($user->insta_user,$user->insta_pass);
        //     $queue = $user->queue->take(15);
        //     if(!$queue){
        //         collect($this->service->getFollowersByUserName('slime_googooliiii'))->map(function($account) use($user){
        //             $queue = new Queue();
        //             $queue->user_id = $user->id;
        //             $queue->queue = $account->getPk();
        //             $queue->save();
        //         });
        //     }else{
        //         return collect($queue)->map(function($q){
        //             $this->service->followByPK($q->queue);
        //             $q->delete();
        //         });
        //     }
        // });

        // --------------
        // $instagram = $this->service->login('b2wall.com1','1352ff2006@#');
        // // return $users = $this->service->getFollowersByUserName('official_arsin')->users;
        // // print_r('<pre>'.$this->service->getAccounts().'</pre>');
        // return $accounts = $this->service->getAccounts();
        // $users_to_follow [] = collect($accounts)->map(function($item){
        //     return $all = array_flatten($this->service->getFollowersByUserName($item->crawlAccount->username)->getUsers());
        // });
        // // return $users_to_follow;
        // return $users_to_follow;
    }
}
