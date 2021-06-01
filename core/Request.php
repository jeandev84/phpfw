<?php
namespace app\core;


/**
 * Class Request
 * @package app\core
*/
class Request
{

     /**
      * @return mixed|string
     */
     public function getPath()
     {
         $path = $_SERVER['REQUEST_URI'] ?? '/';
         $position = strpos($path, '?');

         if($position === false) {
            return $path;
         }

         return substr($path, 0, $position);
     }


     /**
      * @return string
     */
     public function getMethod()
     {
         return strtolower($_SERVER['REQUEST_METHOD']);
     }
}