<?php

namespace Framework;

class EntryPoint
{

    private $routes;

    public function __construct(\Framework\Routes $routes)
    {
        $this->routes = $routes;
    }

    public function run($contents)
    {
        $route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

        $page = $this->routes->getPage($route);

        $output = $this->loadTemplate('../templates/' . $page['template'] . '.html.php', $page['variables']);
        $title = $page['title'];

        require '../templates/layout.html.php';
    }

    public function loadTemplate($fileName, $templateVars)
    {
        extract($templateVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
        return $contents;
    }

    public function load_File($file_name)

    {   
        ob_start();
        require $file_name;
        $contents = ob_get_clean();
        return $contents;
    }

    public function load_header($file_name)

    {
        header('location: ' . $file_name);
    }

    
}
