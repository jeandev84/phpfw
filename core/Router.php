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
         $method = $this->request->method();
         $callback = $this->routes[$method][$path] ?? false;

         if($callback === false) {

             /* Application::$app->response->setStatusCode(404); */
             $this->response->setStatusCode(404);
             /* return $this->renderContent("Not found"); */
             return $this->renderView("errors/_404");
         }

         if (is_string($callback)) {
             return $this->renderView($callback);
         }


         if(is_array($callback)) {
            // on affecte au callback 0 un object
            /* $callback[0] = new $callback[0](); */
             Application::$app->controller = new $callback[0]();
             $callback[0] = Application::$app->controller; // because $this will be calling in not context object
         }

         /* dump($callback); */

         // callable
         return call_user_func($callback, $this->request);
     }



     /**
      * @param string $view
     */
     public function renderView($view, $params = [])
     {
         $layoutContent = $this->layoutContent();
         $viewContent   = $this->renderOnlyView($view, $params);

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
         $layout = Application::$app->controller->layout;
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