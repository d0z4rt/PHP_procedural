<?php 

namespace App\Controllers;

use App\Renderer;

class ErrorController
{
    public function notFounded():Renderer
    {
        

        $view = "error/404";
        // $renderer = new Renderer($view);
        // var_dump($renderer->view());
        return Renderer::makeView($view,[]);

    }

}
