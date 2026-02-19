<?php

Namespace Tests;


use App\Class\UserAccount;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserAccountTest extends TestCase
{
    public function testRegisterEtLogin()
    {
        $user = new UserAccount();
        $user->register("test@email.com", "Password1");

        $this->assertTrue($user->login("test@email.com", "Password1"));
    }

    public function testEmailInvalide()
    {
        $this->expectException(InvalidArgumentException::class);

        $user = new UserAccount();
        $user->register("invalid-email", "Password1");
    }

    public function testMotDePasseCourt()
    {
        $this->expectException(InvalidArgumentException::class);

        $user = new UserAccount();
        $user->register("test@email.com", "short");
    }

    public function testMauvaisLogin()
    {
        $this->expectException(InvalidArgumentException::class);

        $user = new UserAccount();
        $user->register("test@email.com", "Password1");
        $user->login("test@email.com", "WrongPass");
    }

    public function testChangePassword()
    {
        $user = new UserAccount();
        $user->register("test@email.com", "Password1");
        $user->changePassword("Password1", "NewPass1");

        $this->assertTrue($user->login("test@email.com", "NewPass1"));
    }
}