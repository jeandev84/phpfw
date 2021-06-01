<?php
namespace app\core;



/**
 * Class Application
 * @package app\core
*/
class Application
{
     const USED_PHP_VERSION = '7.4.3';

     public Router $router;
     public Request $request;


     /**
      * Application constructor.
     */
     public function __construct()
     {
         $this->request = new Request();
         $this->router = new Router($this->request);
     }


     public function run()
     {
         $this->router->resolve();
     }
}