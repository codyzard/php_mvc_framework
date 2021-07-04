<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            // $this->response->setStatusCode(404);
            // return $this->renderView("_404");
            throw new NotFoundException();
            exit;
        }
        if (is_string($callback)) {
            return $this->view->renderView($callback);
        }
        if (is_array($callback)) {
            //** @var \app\core\Controller $controller */
            $base_controler = new $callback[0]();
            Application::$app->base_controller = $base_controler;
            $base_controler->action =  $callback[1];
            $callback[0] =  $base_controler;
            foreach($base_controler->getMiddleWares() as $middleware){
                $middleware->execute();
            }

            // $callback[0] = new $callback[0](); // [abc::class, 'method'] => callback[0] = class
            //$callback[1] = 'method'
        }
        return call_user_func($callback, $this->request, $this->response);
    }

}
