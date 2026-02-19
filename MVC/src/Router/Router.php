<?php

namespace App\Router;

use App\Exception\RouteNotFoundException;

class Router 
{
    public array $routes;

    public function register(string $path, callable|array $action): void
    {
        $this->routes[$path] = $action;
    }

    public function resolve(string $uri):mixed
    {

        $path = explode("?",$uri)[0];
        $action = $this->routes[$path] ?? null;
        
        if(is_callable($action)){
            return $action;
            
            
        }
        if (is_array($action)) {
            [$class,$method] = $action;

            if(class_exists($class) && method_exists($class, $method)){
                $class = new $class();
                return call_user_func_array([$class,$method], []);
            };
        }
        throw new RouteNotFoundException();
    }
    
}
