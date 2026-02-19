<?php

use App\Kernel;
use App\Router\Router;


// autoloader composer
require "../vendor/autoload.php";


$router = new Router();

$router->register("/", ['App\Controllers\HomeController','index']);
$router->register("/contact", ['App\Controllers\HomeController','contact']);
$router->register("/login", ['App\Controllers\HomeController','login']);
$router->register("/404", ['App\Controllers\ErrorController','notFounded']);

define("BASE_VIEW_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR);


$uri = $_SERVER['REQUEST_URI'];

// supprimer le dossier du projet
$basePath = '/poo/MVC';
$uri = str_replace($basePath, '', $uri);
$uri = $uri ?: '/';


$kernel = new Kernel($router, $uri);
$kernel->run();
