<?php
namespace Core;

class SessionHelper
{
    /**
     * start session if not started
     */
    static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * stop session
     */
    static function stop()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
    }

    /**
     * set session key
     * @param $key
     * @param $value
     */
    static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * remove session key
     * @param $key
     */
    static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * get session key value if exists
     * @param $key
     * @return mixed|null
     */
    static function get($key)
    {
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];

        return null;
    }
}