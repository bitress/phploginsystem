<?php

use Hybridauth\Hybridauth;
class SocialLogin {

    /**
     * @throws \Hybridauth\Exception\InvalidArgumentException
     */
    public function __construct(){
        $hybridauth = new Hybridauth([ /* ... */ ]);
    }

    public function register($proivider, $id){

    }

    public function generateSocialToken(){
        return Others::randomPassword(50);
    }


}