<?php

namespace App\Http\Services;

use InstagramAPI\Instagram;
use InstagramAPI\Signatures;

use App\Account as UserAccounts;
use App\User;
use App\CrawlAccount;
use App\Queue;
use App\Activity;
use Illuminate\Support\Facades\Log;
use App\Log as AppLog;


class InstagramService
{

    protected $rank_token;
    protected $instagram;

    protected $insta_account;

    public function __construct()
    {
        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $this->instagram = new Instagram(false, false);
        // $this->instagram->setProxy('http://ir452013:750990@us.mybestport.com:443');
    }

    public function setUserAccount(User $user){
        $this->insta_account = $user;
    }

    public function login()
    {
        try {
            $loginResponse = $this->instagram->login($this->insta_account->insta_user, $this->insta_account->insta_pass);
            return $result = [
                'status' => 'success',
                'data'   => $loginResponse
            ];
        } catch (\Exception $e) {
            $this->log($e->getMessage(),'error');
            $this->instagram->update(['insta_error' => 1]);
            return $result = [
                'status' => 'error',
                'error'   => $e->getMessage()
            ];
        }
    }
    public function startBot()
    {
        return User::all()->map(function ($user) {
            $instagram = $this->login($user->insta_user, $user->insta_pass);
            if($instagram['status'] == 'error') 
                return $instagram['error'];
            $queue = $this->checkAndFillQueue($user);
            return $this->followFromQueue($queue,$user);
        });
    }

    public function followFromQueue($queue,$user)
    {
        return collect($queue)->map(function ($q)use($user) {
            $user_data = json_decode($q->queue);

            $activity = new Activity();
            $activity->account_id = $user->id;
            $activity->activity = 'follow';
            $activity->details = "$user_data->username followed for $user->insta_user";
            $activity->state = 'succsess';
            $activity->save();

            $this->followByPK($user_data->pk);
            $q->delete();
            return "User $user_data->username successfuly followed";
        });
    }

    public function checkAndFillQueue()
    {
        $queue = $this->insta_account->queue->take(15);
        if (!$queue->count()) {
            $this->addToQueue($this->insta_account);
            return $this->insta_account->queue->take(15);
        }
        return $queue;
    }

    private function addToQueue(User $user)
    {
        $crawl_account = $this->insta_account->crawlAccount;
        if ($crawl_account == null){
            $this->log('This Account do not have any crawl account','error');
            return 'This Account do not have any crawl account.';
        }
        $get_followers = $this->getFollowersByUserName($user);

        return collect($get_followers)->map(function ($account) {
            $queue = new Queue();
            $queue->user_id = $this->insta_account->id;
            $queue->queue = $account;
            return $queue->save();
        });
        $this->log('Queue filled','success');
    }

    public function uuid()
    {
        return Signatures::generateUUID();
    }

    public function getUserIdOnUserName($username)
    {
        return $this->instagram->people->getUserIdForName($username);
    }

    public function getFollowersByUserName()
    {
        $acc = $this->insta_account->crawlAccount;
        $user_id = $this->getUserIdOnUserName($acc->username);
        try {
            $followers =  $this->instagram->people->getFollowers("$user_id", $this->uuid(), null, $acc->next_page);
        } catch (\Exeption $e) {
            $acc->update(['error' => 1]);
            $this->log('Error on following','error');
         }
        $acc->update(['next_page' => $followers->getNext_max_id()]);
        return $followers->getUsers();
    }

    public function followByPK($user_id)
    {
        return $this->instagram->people->follow($user_id);
    }

    public function getAccounts()
    {
        return UserAccounts::with(['crawlAccount'])->get();
    }

    public function sendDirectMessage($recipient, $text)
    {
        $to = Array();
        $to['users'][] = $this->getUserIdOnUserName($recipient);
        // return $to;
        return $this->instagram->direct->sendText($to,$text);
    }

    public function log($log,$type = null){
        $log = new AppLog();
        $log->user_id = $this->insta_account->id;
        $log->type = $type;
        $log->log = $log;
        return $log->save();
    }
}
