<?php

namespace App\Exception;

class RouteNotFoundException extends \Exception
{
    protected $message = "Cette route n'existe pas.";
}
