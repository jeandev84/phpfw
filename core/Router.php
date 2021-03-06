<?php
namespace app\core;


use app\core\exception\NotFoundException;

/**
 * Class Router
 * @package app\core
*/
class Router
{


     /**
      * @var Request
     */
     protected Request $request;


     /**
      * @var Response
     */
     protected Response $response;



     /**
      * @var array
     */
     protected array $routes = [];


     /**
       * Router constructor.
       *
       * @param Request $request
      * @param Response $response
     */
     public function __construct(Request $request, Response $response)
     {
          $this->request = $request;
          $this->response = $response;
     }



     /**
       * @param $path
       * @param $callback
     */
     public function get($path, $callback)
     {
          $this->routes['get'][$path] = $callback;
     }



     /**
      * @param $path
      * @param $callback
     */
     public function post($path, $callback)
     {
         $this->routes['post'][$path] = $callback;
     }


     /**
      * Resolve
     */
     public function resolve()
     {
         $path = $this->request->getPath();
         $method = $this->request->method();
         $callback = $this->routes[$method][$path] ?? false;

         if($callback === false) {
             throw new NotFoundException();
         }

         if (is_string($callback)) {
             return Application::$app->view->renderView($callback);
         }


         if(is_array($callback)) {
             /** @var Controller $controller */
             $controller = new $callback[0]();
             Application::$app->controller = $controller;
             $controller->action = $callback[1];
             $callback[0] = $controller; // because $this will be calling in not context object

             foreach ($controller->getMiddlewares() as $middleware) {
                   $middleware->execute();
             }
         }

         /* dump($callback); */

         // callable
         return call_user_func($callback, $this->request, $this->response);
     }
}