<?php

namespace App\Http\Services;
use InstagramAPI\Instagram;
use InstagramAPI\Signatures;


class InstagramService
{

    protected $rank_token;
    protected $instagram;
    
    public function __construct()
    {
        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $this->instagram = new Instagram(false,false);
        $this->instagram->setProxy('http://ir452013:750990@us.mybestport.com:443');
    }

    public function login($username,$password)
    {
        try {
            return $loginResponse = $this->instagram->login($username, $password);
		} catch (\Exception $e) {
		    echo 'Something went wrong: '.$e->getMessage()."\n";
		}
    }

    public function uuid(){
        return $this->rank_token = Signatures::generateUUID();
    }

    public function getUserIdOnUserName($username){
        return $this->instagram->people->getUserIdForName('farshadfakhar');
    }

}
