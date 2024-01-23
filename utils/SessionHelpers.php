<?php


namespace utils;


class SessionHelpers
{
    public function __construct()
    {
        SessionHelpers::init();
    }

    static function init(): void
    {
        session_start();
    }

    static function login(mixed $user): void
    {
        $_SESSION['LOGIN'] = $user;
    }

    static function email(mixed $email) : void 
    {
        $_SESSION['EMAIL'] = $email;    
    }

    static function logout(): void
    {
        unset($_SESSION['LOGIN']);
        session_unset();

    }

    static function getConnected(): mixed
    {
        if (SessionHelpers::isLogin()) {
            return $_SESSION['LOGIN'];
        } else {
            return false;
        }
    }

    static function isLogin(): bool
    {
        return isset($_SESSION['LOGIN']);
    }

    public static function isConnected(): bool
    {
        return SessionHelpers::isLogin();
    }

    public static function isAdmin() :bool{
        if(SessionHelpers::isLogin()){
            if($_SESSION['LOGIN']->admin == 1){
                return true;
            }
        }
        return false;
    }
}