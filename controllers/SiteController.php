<?php
namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;


/**
 * Class SiteController
 * @package app\controllers
*/
class SiteController extends Controller
{

    /**
     * Show contact form
     * @return string
    */
    public function home()
    {
        $params = [
            'name' => "TheCodeholic"
        ];

        return $this->render('home', $params);
    }


     /**
      * Show contact form
      * @return string
     */
     public function contact()
     {
          return $this->render('contact');
     }


    /**
     * Show contact view
     *
     * @return string
    */
    public function handleContact(Request $request)
    {
        $body = $request->getBody();

        return "Handling submitted data";
    }
}