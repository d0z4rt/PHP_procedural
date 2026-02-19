<?php
namespace App;

use App\Router\Router;
use App\Exception\RouteNotFoundException;

class Kernel
{
    private string $basePath = '/poo/MVC';

    public function __construct(
        private Router $router,
        private string $requesturi
    ) {}

    public function run(): void
    {


        try {
            echo $this->router->resolve($this->requesturi);
            } catch (RouteNotFoundException $e) {
            echo $this->router->resolve('/404');
            // echo $e->getMessage();
        }
    }
}