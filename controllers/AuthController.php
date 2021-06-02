<?php
namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\User;


/**
 * Class AuthController
 * @package app\controllers
*/
class AuthController extends Controller
{
     public function login()
     {
         $this->setLayout('auth');
         return $this->render('login');
     }


    /**
     * @param Request $request
     * @return array|false|string|string[]
    */
    public function register(Request $request)
    {
        $user = new User();

        if($request->isPost()) {

            /* dump($request->getBody()); */
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()) {
                return "Success";
            }

            return $this->render('register', [
                'model' => $user
            ]);
        }

        $this->setLayout('auth');

        return $this->render('register', [
            'model' => $user
        ]);
    }
}