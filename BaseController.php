<?php


namespace app\core;

use app\core\middlewares\BaseMiddleware;

class BaseController
{
    public string $layout = 'main';
    protected array $middlewares = [];
    public string $action = '';

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;

    }

    public function getMiddleWares(): array
    {   
        return $this->middlewares;
    }
}
