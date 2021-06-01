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
         $method = $this->request->getMethod();
         $callback = $this->routes[$method][$path] ?? false;

         if($callback === false) {

             /* Application::$app->response->setStatusCode(404); */
             $this->response->setStatusCode(404);
             return "Not found";
         }

         if (is_string($callback)) {
             return $this->renderView($callback);
         }

         return call_user_func($callback);
     }



     /**
      * @param string $view
     */
     public function renderView($view)
     {
         $layoutContent = $this->layoutContent();
         $viewContent   = $this->renderOnlyView($view);

         return str_replace("{{content}}", $viewContent, $layoutContent);

         /* include_once Application::$ROOT_DIR. "/views/{$view}.php"; */
     }


     /**
      * @return false|string
     */
     protected function layoutContent()
     {
         ob_start();
         include_once Application::$ROOT_DIR. "/views/layouts/main.php";
         return ob_get_clean();
     }



     /**
      * @param $view
      * @return false|string
     */
     public function renderOnlyView($view)
     {
         ob_start();
         include_once Application::$ROOT_DIR. "/views/{$view}.php";
         return ob_get_clean();
     }
}