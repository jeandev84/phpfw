<?php
namespace app\core;


use app\core\Router;


/**
 * Class Application
 * @package app\core
*/
class Application
{
     const USED_PHP_VERSION = '7.4.3';

     public Router $router;

     public function __construct()
     {
         $this->router = new Router();
     }


     public function run()
     {

     }
}