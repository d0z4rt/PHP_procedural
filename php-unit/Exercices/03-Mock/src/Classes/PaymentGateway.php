<?php

Namespace App\Classes;

class PaymentGateway
{
    
    public function charge(int $amout):array
    {
        
        return ["status" => "success"];
    }
}
