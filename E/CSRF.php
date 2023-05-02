<?php

class CSRF {

    /** Session var name
     * @var string
     */
    public static string $session = '_CSRF';

    /** Generate CSRF value for form
     * @param string|null $form - Form name as session key
     * @return    string    - token
     * @throws Exception
     */
    static function generate(string $form = NULL): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION[CSRF::$session . '_' . $form] = $token;
        return $token;
    }

    /** Check CSRF value of form
     * @param string $token	- Token
     * @param string|null $form	- Form name as session key
     * @return	boolean
     */
    public static function check(string $token, string $form = NULL): bool
    {
        if (isset($_SESSION[CSRF::$session . '_' . $form]) && hash_equals($_SESSION[CSRF::$session . '_' . $form], $token)) {
            return true;
        }
        return false;
    }

}
