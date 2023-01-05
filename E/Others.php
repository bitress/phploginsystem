<?php

/**
 * Other functions
 */
class Others
{

    /**
     * Get user ip address
     * @return mixed
     */
    public static function getUserIpAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Generate string that will be used as fingerprint.
     * This is actually string created from user's browser name and user's IP address, so if someone steals users session, he won't be able to access.
     * @return string Generated string.
     */
    public static function generateLoginString(): string
    {
        $userIP = self::getUserIpAddress();
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        return hash('sha512',$userIP . $userBrowser);
    }


    /**
     * Generate key used
     * @return string Generated key.
     */
    public static function generateKey(): string
    {

        $uniquekey = self::generateLoginString();

        return md5(time() . $uniquekey . time());
    }

    /**
     * Upload user's avatar
     * @param $file
     * @return string|void
     */
    public static function uploadAvatar($file)  {
        if(isset($file))
        {
            $extension = explode('.', $file['name']);
            $new_name = self::generateKey() . '.' . $extension[1];
            $destination = '../uploads/avatars/' . $new_name;
            move_uploaded_file($file['tmp_name'], $destination);
            return $new_name;
        }
    }


    public static function relativeDate($datetime) {
        $now = strtotime(date('M j, Y'));

        $relativeDay = ($datetime - $now) / 86400;

        if ($relativeDay >= 0 && $relativeDay < 1) {
            return 'Today ' . date('h:i A', $datetime);
        }

        if ($relativeDay >= -1 && $relativeDay < 0) {
            return 'Yesterday '. date('h:i A', $datetime);
        }

        if (abs($relativeDay) > 2) {

            return date('l, j F, Y h:i A', $datetime);
        }
    }

}