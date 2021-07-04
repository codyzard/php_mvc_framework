<?php

namespace hoangtu\phpmvc;

use hoangtu\phpmvc\database\Database;
use hoangtu\phpmvc\database\DbModel;
use app\models\User;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public Request $request;
    public Response $response;
    public Session $session;
    public string $userClass;
    public Router $router;
    public Database $db;
    public ?DbModel $user; // ?DbModel
    public static Application $app;
    public ?BaseController $base_controller = null;
    public View $view;
    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e,
            ]);
        }
    }

    public function getController()
    {
        return $this->base_controller;
    }

    public function setController(BaseController $base_controller)
    {
        $this->base_controller = $base_controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
