<?php
namespace app\core;


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
      * @var array
     */
     protected array $routes = [];



     /**
      * Router constructor.
      * @param Request $request
     */
     public function __construct(Request $request)
     {
          $this->request = $request;
     }



     /**
       * @param $path
       * @param callable $callback
     */
     public function get($path, callable $callback)
     {
          $this->routes['get'][$path] = $callback;
     }



     /**
      * Resolve
     */
     public function resolve()
     {
         $path = $this->request->getPath();
         $method = $this->request->getMethod();
         $callback = $this->routes[$method][$path] ?? false;

         if($callback === false) {
             dd("Not found");
         }

         echo call_user_func($callback);
     }
}