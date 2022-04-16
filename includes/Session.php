<?php

class Session {

    public static function startSession(){


        if ( '' === session_id() )
        {
            $secure = true;
            $httponly = true;



            $params = session_get_cookie_params();
            session_set_cookie_params($params['lifetime'],
                $params['path'], $params['domain'],
                $secure, $httponly
            );

            return session_start();
        }
        // Helps prevent hijacking by resetting the session ID at every request.
        // Might cause unnecessary file I/O overhead?
        // TODO: create config variable to control regenerate ID behavior
        return session_regenerate_id(true);
    }


    public static function setSession($index, $value) {
        $_SESSION[$index] = $value;
    }

    public static function getSession($index){
        return isset($_SESSION[$index]) ? $_SESSION[$index] : null;
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