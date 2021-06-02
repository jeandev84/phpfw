<?php
namespace app\core\middlewares;


use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 * @package app\core\middlewares
*/
class AuthMiddleware extends BaseMiddleware
{

    /**
     * @var array
    */
    protected array $actions = [];


    /**
     * AuthMiddleware constructor.
     * @param array $actions
    */
    public function __construct(array $actions = [])
    {
         $this->actions = $actions;
    }


    /**
     * @throws ForbiddenException
    */
    public function execute()
    {
       if(Application::isGuest()) {
           $currentAction = Application::$app->controller->action;
           if(empty($this->actions) || in_array($currentAction, $this->actions)) {
               throw new ForbiddenException();
           }
       }
    }
}