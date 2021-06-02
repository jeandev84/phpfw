<?php
namespace app\core\exception;


/**
 * Class NotFoundException
 * @package app\core\exception
*/
class NotFoundException extends \Exception
{
     protected $message = 'Page not found';
     protected $code = 404;
}