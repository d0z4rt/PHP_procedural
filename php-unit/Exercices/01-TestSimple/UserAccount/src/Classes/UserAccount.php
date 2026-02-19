<?php

declare(strict_types=1);

namespace App\Classes;

class UserAccount
{
    private string $email;

    private string $password;

    private static array $cacheEmail = ["previuseail@user.fr"];

    public function register(string $email, string $password): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Cette email est invalide");
        }

        if (in_array($email, self::$cacheEmail)) {
            throw new \InvalidArgumentException("Email deja utilisé");
        }

        if (strlen($password) < 8) {

            throw new \InvalidArgumentException("Mot de passe trop court");
        }


        self::$cacheEmail[] = $email;

        $this->email = $email;
        $this->password = $password;
    }

    public function login(string $email, string $password)
    {
        return $this->email === $email && $this->password === $password;
    }

    public function changePassword(string $old, string $new): void {}

    public static function flushCache(){
        self::$cacheEmail = [];
    }
}
