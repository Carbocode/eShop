<?php
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

JWT::$leeway = 20;

class Authentication
{
    private $secret_key = "VkYp3s6v9y/B?E(H+MbQeThWmZq4t7w!";
    public $userInfo = null;

    public function __construct($token, $cookie)
    {
        try {
            $arr = explode(" ", $token);
            $temp = JWT::decode($arr[1], new Key($this->secret_key, 'HS256'));

            if ($this->isAuth($temp->ident, $cookie)) {
                $this->userInfo = $temp;
            }
        } catch (\Exception $e) {
        }
    }

    private function isAuth($token, $cookie)
    {
        if ($token == md5($cookie)) {
            return True;
        } else {
            return False;
        }
    }

    //verifica se l'utente è loggato
    public function isLogged(): bool
    {
        try {
            if (isset($this->userInfo->name)) {
                return True;
            } else {
                return False;
            }
        } catch (\Exception $e) {
            return False;
        }
    }

    //verifica se l'utente è admin
    public function isAdmin(): bool
    {
        try {
            if ($this->isLogged()) {
                if ($this->userInfo->tipo == "admin") {
                    return True;
                } else {
                    return False;
                }
            }
        } catch (\Exception $e) {
            return False;
        }
    }
}