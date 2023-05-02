<?php

/**
 * A class that provides functionality for auto-logout after a specified period of inactivity.
 */
class AutoLogout {

    /**
     * The timeout period (in seconds).
     *
     * @var int
     */
    private int $timeout;

    /**
     * The URL to redirect to when the user is logged out.
     *
     * @var string
     */
    private string $redirect_url;

    public function __construct() {
        $this->timeout = AUTO_LOGOUT_TIME;
        $this->redirect_url = LOGOUT_REDIRECT;
    }

    /**
     * Checks if the user has been inactive for longer than the specified timeout period.
     * If so, destroys the session and redirects to the specified URL.
     */
    public function checkActivity(): void
    {
        if (Session::checkSession('last_activity') && (time() - Session::getSession('last_activity')) > $this->timeout) {
            session_unset();
            Session::destroySession();
            header('Location: ' . $this->redirect_url);
            exit();
        } else {
            Session::setSession('last_activity', time());
        }
    }
}
