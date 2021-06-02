<?php
namespace app\core;



use app\core\db\Database;


/**
 * Class Application
 * @package app\core
*/
class Application
{
     const USED_PHP_VERSION = '7.4.3';

     public static string $ROOT_DIR;


     public string $layout = 'main';
     public string $userClass;
     public Router $router;
     public Request $request;
     public Response $response;
     public Database $db;
     public ?UserModel $user;
     public View $view;

     public Session $session;
     public ?Controller $controller = null;
     public static Application $app;


     /**
      * Application constructor.
      * @param $rootPath
      * @param array $config
     */
     public function __construct($rootPath, array $config)
     {
         $this->userClass = $config['userClass'];
         self::$ROOT_DIR = $rootPath;
         self::$app = $this;
         $this->request  = new Request();
         $this->response = new Response();
         $this->session  = new Session();
         $this->router   = new Router($this->request, $this->response);
         $this->view     = new View();


         $this->db = new Database($config['db']);
         $primaryValue = $this->session->get('user');

         if($primaryValue) {
             $primaryKey = $this->userClass::primaryKey();
             $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
         } else{
             $this->user = null;
         }
     }


     /**
      * Run the application
     */
     public function run()
     {
         try {

             echo $this->router->resolve();

         } catch (\Exception $e) {

             $this->response->setStatusCode($e->getCode());
             echo $this->view->renderView('_error', [
                 'exception' => $e
             ]);
         }
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


     /**
      * @param UserModel $user
      * @return bool
     */
     public function login(UserModel $user)
     {
         $this->user = $user;
         $primaryKey = $user->primaryKey();
         $primaryValue = $user->{$primaryKey};
         $this->session->set('user', $primaryValue);
         return true;
     }


    /**
     * @return void
    */
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }


    /**
     * @return DbModel|null
    */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return bool
    */
    public static function isGuest()
    {
        return ! self::$app->user;
    }
}