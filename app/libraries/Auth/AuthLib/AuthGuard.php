<?php namespace Auth\AuthLib;

use Illuminate\Cookie\CookieJar;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Encryption\Encrypter;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Session\Store as SessionStore;
use Symfony\Component\HttpFoundation\Response;

class AuthGuard extends \Illuminate\Auth\Guard {

/**
* @param number which represents privelege level
* @return boolean whether Auth user greater than that level
*/


/*
Lets say 
Privelege Level                   User
1								Plain old loser
15 								Moderator
17								Teacher
20								Admin
*/
public function privelegecheck($privelege_level){
        $authorized=false;
        if($this->check()){
                if($this->user->privelege_level>=$privelege_level)
                        $authorized=true;
        }
        return $authorized;
} 
        
}
