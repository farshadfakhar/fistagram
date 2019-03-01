<?php

namespace App\Http\Services;

use InstagramAPI\Instagram;
use InstagramAPI\Signatures;

use App\Account as UserAccounts;
use App\User;
use App\CrawlAccount;
use App\Queue;


class InstagramService
{

    protected $rank_token;
    protected $instagram;

    public function __construct()
    {
        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $this->instagram = new Instagram(false, false);
        $this->instagram->setProxy('http://ir452013:750990@us.mybestport.com:443');
    }

    public function login($username, $password)
    {
        try {
            return $loginResponse = $this->instagram->login($username, $password);
        } catch (\Exception $e) {
            echo 'Something went wrong: ' . $e . "\n";
        }
    }
    public function startBot()
    {
        return User::all()->map(function ($user) {
            $instagram = $this->login($user->insta_user, $user->insta_pass);
            return $queue = $this->checkAndFillQueue($user);
            return $this->followFromQueue($queue);
        });
    }

    public function followFromQueue($queue)
    {
        return collect($queue)->map(function ($q) {
            $user_data = json_decode($q->queue);
            $this->followByPK($user_data->pk);
            $q->delete();
            return "User $user_data->username successfuly followed";
        });
    }

    public function checkAndFillQueue(User $user)
    {
        $queue = $user->queue->take(15);
        if (!$queue->count()) {
            $this->addToQueue($user);
            return $user->queue->take(15);
        }
        return $queue;
    }

    private function addToQueue(User $user)
    {
        $crawl_account = $user->crawlAccount;
        if ($crawl_account == null)
        return 'This Account do not have any crawl account.';
        $get_followers = $this->getFollowersByUserName($user);
        return collect($get_followers)->map(function ($account) use ($user) {
            $queue = new Queue();
            $queue->user_id = $user->id;
            $queue->queue = $account;
            return $queue->save();
        });
    }

    public function uuid()
    {
        return Signatures::generateUUID();
    }

    public function getUserIdOnUserName($username)
    {
        return $this->instagram->people->getUserIdForName($username);
    }

    public function getFollowersByUserName(User $user)
    {
        $acc = $user->crawlAccount;
        $user_id = $this->getUserIdOnUserName($acc->username);
        $followers =  $this->instagram->people->getFollowers("$user_id", $this->uuid(), null, $acc->next_page);
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
}
