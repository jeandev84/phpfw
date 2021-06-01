<?php
namespace app\core;


/**
 * Class Controller
 * @package app\core
*/
class Controller
{

     /**
      * @var string
     */
     public string $layout = 'main';


     /**
      * @param $layout
     */
     public function setLayout($layout)
     {
         $this->layout = $layout;
     }


     /**
      * @param $view
      * @param array $params
      * @return array|false|string|string[]
     */
     public function render($view, $params = [])
     {
         return Application::$app->router->renderView($view, $params);
     }
}