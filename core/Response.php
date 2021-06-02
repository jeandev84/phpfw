<?php
namespace app\core;


/**
 * Class Response
 * @package app\core
*/
class Response
{

     /**
      * @param int $code
     */
     public function setStatusCode(int $code)
     {
         http_response_code($code);
     }


     /**
      * @param string $path
     */
     public function redirect(string $path)
     {
          header('Location: '. $path);
     }
}