<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct($actions)
    {
        $this->actions = $actions;
    }

    public function execute(){
        if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->base_controller->action, $this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}
