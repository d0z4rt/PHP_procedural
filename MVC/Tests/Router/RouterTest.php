<?php

namespace Tests\Router;

use PHPUnit\Framework\TestCase;
use App\Router\Router;
use App\Exception\RouteNotFoundException;
use Tests\Controller\FakeController;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    /**
     * Test l'enregistrement d'une route avec une fonction
     */
    public function testRegisterClosureRoute()
    {
        $closure = function() { return "hello"; };
        
        $this->router->register('/test', $closure);
        
        $this->assertArrayHasKey('/test', $this->router->routes);
        $this->assertSame($closure, $this->router->routes['/test']);
    }

    /**
     * Test l'enregistrement d'une route avec un controller
     */
    public function testRegisterControllerRoute()
    {
        $action = [FakeController::class, 'index'];
        
        $this->router->register('/test', $action);
        
        $this->assertArrayHasKey('/test', $this->router->routes);
        $this->assertSame($action, $this->router->routes['/test']);
    }

    /**
     * Test la résolution d'une route avec une fonction anonyme
     */
    public function testResolveClosureRoute()
    {
        $closure = function() { return "hello world"; };
        $this->router->register('/test', $closure);
        
        $result = $this->router->resolve('/test');
        
        $this->assertSame($closure, $result);
    }

    /**
     * Test la résolution d'une route avec un controller
     */
    public function testResolveControllerRoute()
    {
        $this->router->register('/test', [TestController::class, 'index']);
        
        $result = $this->router->resolve('/test');
        
        $this->assertEquals("index method", $result);
    }

    /**
     * Test la résolution d'une route avec query string
     */
    public function testResolveWithQueryString()
    {
        $closure = function() { return "with query"; };
        $this->router->register('/test', $closure);
        
        $result = $this->router->resolve('/test?id=1&page=2');
        
        $this->assertSame($closure, $result);
    }

    /**
     * Test la résolution de plusieurs routes différentes
     */
    public function testResolveMultipleRoutes()
    {
        $this->router->register('/home', function() { return "home"; });
        $this->router->register('/about', [TestController::class, 'show']);
        $this->router->register('/contact', function() { return "contact"; });
        
        $this->assertIsCallable($this->router->resolve('/home'));
        $this->assertEquals("show method", $this->router->resolve('/about'));
        $this->assertIsCallable($this->router->resolve('/contact'));
    }

    /**
     * Test la résolution d'une route qui n'existe pas
     */
    public function testResolveThrowsExceptionWhenRouteNotFound()
    {
        $this->expectException(RouteNotFoundException::class);
        
        $this->router->resolve('/page-inexistante');
    }

    /**
     * Test avec un controller qui n'existe pas
     */
    public function testResolveWithNonExistentController()
    {
        $this->router->register('/test', ['NonExistentClass', 'index']);
        
        $this->expectException(RouteNotFoundException::class);
        
        $this->router->resolve('/test');
    }

    /**
     * Test avec une méthode qui n'existe pas dans le controller
     */
    public function testResolveWithNonExistentMethod()
    {
        $this->router->register('/test', [TestController::class, 'nonExistentMethod']);
        
        $this->expectException(RouteNotFoundException::class);
        
        $this->router->resolve('/test');
    }

    /**
     * Test l'enregistrement de plusieurs routes
     */
    public function testRegisterMultipleRoutes()
    {
        $this->router->register('/a', function() { return "a"; });
        $this->router->register('/b', function() { return "b"; });
        $this->router->register('/c', function() { return "c"; });
        
        $this->assertCount(3, $this->router->routes);
    }

    /**
     * Test avec des slashs dans l'URI
     */
    public function testResolveWithMultipleSlashes()
    {
        $this->router->register('/user/profile', function() { return "profile"; });
        
        $result = $this->router->resolve('/user/profile');
        
        $this->assertIsCallable($result);
    }

    /**
     * Test la résolution d'une route sans query string
     */
    public function testResolveWithoutQueryString()
    {
        $this->router->register('/simple', function() { return "simple"; });
        
        $result = $this->router->resolve('/simple');
        
        $this->assertIsCallable($result);
    }
}