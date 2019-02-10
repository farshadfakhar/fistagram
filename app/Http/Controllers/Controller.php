<?php

namespace App\Http\Controllers;
use InstagramAPI\Instagram;
use InstagramAPI\Signatures;

use App\Http\Services\InstagramService;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    

    public function __construct(InstagramService $service)
    {
        $this->service = $service;
    }

    public function login()
    {
        $instagram = $this->service->login('persiapotek','1352ff2006@#');
        print_r('<pre>'.$this->service->getFollowersByUserName('official_arsin').'</pre>');
        // print_r($this->service->uuid());
    }
}
