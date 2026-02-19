<?php 

namespace App\Controllers;

use App\Renderer;
use App\Model\User;

class HomeController extends AbstractController
{
    public function index():Renderer
    {

        $view = "home/index";
        // $renderer = new Renderer($view);
        // var_dump($renderer->view());
        $user = new User();
        $users = $user->all();
        return Renderer::makeView($view, ["user" => $users]);

    }
    public function login():Renderer
    {
        
        $view = "login/index";
        $form = $this
            ->add("username", "text", [])
            ->add("password", "password", [])
            ->getForm();

        $form->handle($_POST);

        if($form->isValid()){
            // traitement
            $data = $form->getData();

        }
        return Renderer::makeView($view,["form" => $form]);

    }
    public function contact(){
        $view = "contact/index";
        // $renderer = new Renderer($view);
        // var_dump($renderer->view());
        // $userModel = new User();
        // $users = $userModel->all();
        return Renderer::makeView($view, []);
    }
}
