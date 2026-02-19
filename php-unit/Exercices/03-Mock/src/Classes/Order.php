<?php

Namespace App\Classes;

class Order
{

    public function __construct(
        public int $id,
        public int $amount,
    )
    {}
}
