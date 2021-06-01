<?php
namespace app\core;



/**
 * Class Application
 * @package app\core
*/
class Application
{
     const USED_PHP_VERSION = '7.4.3';

     public static string $ROOT_DIR;
     public Router $router;
     public Request $request;
     public Response $response;
     public Controller $controller;
     public static Application $app;


     /**
      * Application constructor.
     */
     public function __construct($rootPath)
     {
         self::$ROOT_DIR = $rootPath;
         self::$app = $this;
         $this->request  = new Request();
         $this->response = new Response();
         $this->router   = new Router($this->request, $this->response);
     }


    /**
     * @return Controller
    */
    public function getController(): Controller
    {
          return $this->controller;
    }



    /**
     * @param Controller $controller
     * @return Application
     */
     public function setController(Controller $controller): Application
     {
         $this->controller = $controller;

         return $this;
     }


     public function run()
     {
         echo $this->router->resolve();
     }
}