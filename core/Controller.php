<?php
namespace app\core;


use app\core\middlewares\BaseMiddleware;

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
      * @var string
     */
     public string $action = '';



     /**
      * @var array
     */
     protected array $middlewares = [];



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
         return Application::$app->view->renderView($view, $params);
     }


     /**
      * @param BaseMiddleware $middleware
     */
     public function registerMiddleware(BaseMiddleware $middleware)
     {
           $this->middlewares[] = $middleware;
     }


     /**
      * @return array
     */
     public function getMiddlewares(): array
     {
          return $this->middlewares;
     }
}