<?php

namespace hoangtu\core;

class View
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        //cho ni lam cai layout main de child co the inherit
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent); // replace cai' {{content trong main = view tuong ung}}
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        //ham main layout
        $layout = Application::$app->layout;
        if (Application::$app->base_controller) {
            $layout = Application::$app->base_controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/Views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/Views/$view.php";
        return ob_get_clean();
    }
}
