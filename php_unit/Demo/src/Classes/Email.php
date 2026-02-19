<?php

namespace App\Classes;

final class Email 
{
    private function __construct( private string $email ) {
        
        $this->ensureValidEmail($email);
    }


    private function ensureValidEmail(string $email):void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException(
                sprintf('"%s" is not an email adress',
                $email)
                );
        }
    }

    public static function fromString(string $email):self
    {
        return new self($email);
    }

    public function asString():string
    {
        return $this->email;
    }
}
