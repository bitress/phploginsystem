<?php

class Session extends \SessionHandler
{
    private static  $_instance;
    private string $sessionName = 'my_secure_session';
    private int $sessionMaxLifetime = 1800; // 30 minutes
    private bool $sessionSSL = true;
    private bool $sessionHTTPOnly = true;
    private string $sessionSameSite = 'Strict';


    public function __construct()
    {
        // Set session name
        session_name($this->sessionName);

        // Set session cookie parameters
        session_set_cookie_params(
            $this->sessionMaxLifetime,
            '/',
            '',
            $this->sessionSSL,
            $this->sessionHTTPOnly
        );

        // Set session cookie SameSite policy
        if (PHP_VERSION_ID >= 70300) {
            session_set_cookie_params([
                'samesite' => $this->sessionSameSite
            ]);
        }

        // Set session handler to use encryption
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', $this->sessionSSL);
        ini_set('session.cookie_httponly', $this->sessionHTTPOnly);

        // Start session
        session_start();

        // Regenerate session ID on every request
        session_regenerate_id(true);


    }

    public static function startSession()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
    }

    public static function setSession($index, $value) {
        $_SESSION[$index] = $value;
    }

    public static function getSession($index){
        return $_SESSION[$index] ?? null;
    }

    public static function checkSession($index) {
        if(isset($_SESSION[$index])){
            return true;
        } else {
            return false;
        }
    }

    public static function unsetSession($index) {
        unset($_SESSION[$index]);
    }

    public static function destroySession(){
        session_destroy();
    }


}
