<?php
namespace app\core;


/**
 * Class View
 * @package app\core
*/
class View
{
     public string $title = '';


    /**
     * @param string $view
     */
    public function renderView($view, $params = [])
    {
        $viewContent   = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}", $viewContent, $layoutContent);

        /* include_once Application::$ROOT_DIR. "/views/{$view}.php"; */
    }


    /**
     * @param $viewContent
     * @return array|false|string|string[]
     */
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}", $viewContent, $layoutContent);

        /* include_once Application::$ROOT_DIR. "/views/{$view}.php"; */
    }



    /**
     * @return false|string
     */
    protected function layoutContent()
    {
        $layout = Application::$app->layout;

        if($controller = Application::$app->controller) {
            $layout = $controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR. "/views/layouts/{$layout}.php";
        return ob_get_clean();
    }


    /**
     * @param $view
     * @param $params
     * @return false|string
     */
    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        // extract($params);
        ob_start();
        include_once Application::$ROOT_DIR. "/views/{$view}.php";
        return ob_get_clean();
    }
}