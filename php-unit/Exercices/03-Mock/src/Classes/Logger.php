<?php

Namespace App\Classes;

class Logger 
{
    
    public function log(string $message):void
    {
        echo "Log : $message";
    }
}
