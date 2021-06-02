<?php
namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;
use app\core\middlewares\AuthMiddleware;


/**
 * Class AuthController
 * @package app\controllers
*/
class AuthController extends Controller
{


    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    /**
      * @param Request $request
      * @param Response $response
      * @return array|false|string|string[]
     */
     public function login(Request $request, Response $response)
     {
         $loginForm = new LoginForm();

         if ($request->isPost()) {
              $loginForm->loadData($request->getBody());

              if ($loginForm->validate() && $loginForm->login()) {
                  $response->redirect('/');
                  return;
              }
         }

         $this->setLayout('auth');
         return $this->render('login', [
             'model' => $loginForm
         ]);
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
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
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


    /**
     * @param Request $request
     * @param Response $response
    */
    public function logout(Request $request, Response $response)
    {
         Application::$app->logout();
         $response->redirect('/');

         return;
    }


    public function profile()
    {
        return $this->render('profile', [

        ]);
    }
}