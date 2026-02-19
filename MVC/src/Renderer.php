<?php

namespace App;

// Renderer permet de gere le rendu des vu en fonction des path
class Renderer{
    public function __construct(private string $viewpath, private ?array $params)
    {}

    public function view():string|bool
    {

        ob_start();
        
        extract($this->params);

        require BASE_VIEW_PATH . $this->viewpath . ".php";

        return ob_get_clean();
    }

    /**
     * Undocumented function
     *
     * @param string $viewPath
     * @param array|null $params
     * @return static
     */
    public static function makeView(string $viewPath, ?array $params):static
    {
        
        return new static($viewPath, $params);
    }

    public function __toString()
    {
        return $this->view();
    }
}