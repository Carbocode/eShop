<?php
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication
{
    private $secret_key = "s22wyX!!iYT@rQ#WT#5wbSb95R@^WD$3BJZdy8imxB4GRk3NYFP3H7YQbtnX*Mktb^72CTrq!JxQUqYG%3GJor8XFVyuaczMCb7nA2M&hh7zpb76%te!Xzs9@RrEDE^4";
    public $userInfo = null;

    function __construct($token)
    {
        try {
            $this->userInfo = JWT::decode($token, new Key($this->secret_key, 'HS256'));
        } catch (\Exception $e) {
        }
    }
    public function lmao()
    {
        return $this->userInfo;
    }

    //verifica se l'utente è loggato
    public function isLogged(): bool
    {
        if (isset($this->userInfo->name)) {
            return True;
        } else {
            return False;
        }
    }

    //verifica se l'utente è admin
    public function isAdmin(string $token): bool
    {
        if ($this->userInfo->tipo == "admin") {
            return True;
        } else {
            return False;
        }
    }
}