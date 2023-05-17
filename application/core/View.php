<?php

namespace application\core;

class View
{

    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        $viewPath = 'application/views/' . $this->path . '.php';

        extract($vars, EXTR_PREFIX_ALL, 'data');
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            require 'application/views/layout/' . $this->layout . '.php';
        }
        exit;
    }

    public static function errorCode($code)
    {
        $errorViewPath = 'application/views/errors/' . $code . '.php';

        http_response_code($code);
        if (file_exists($errorViewPath)) {
            require 'application/views/errors/' . $code . '.php';
        }
        exit;
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }
}
