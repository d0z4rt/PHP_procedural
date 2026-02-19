<?php

Namespace App\Classes;

class Mailer 
{
    
    public function send(string $mail, $message):bool
    {
        echo "send message to : $mail, content : $message";
        return true;
    }
}
