<?php
namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;


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
     public function contact(Request $request, Response $response)
     {
          $contact = new ContactForm();

          if($request->isPost()) {
              $contact->loadData($request->getBody());

              if ($contact->validate() && $contact->send()) {
                   Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                   return $response->redirect('/contact');
              }
          }

          return $this->render('contact', [
              'model' => $contact
          ]);
     }


//    /**
//     * Show contact view
//     *
//     * @return string
//    */
//    public function handleContact(Request $request)
//    {
//        $body = $request->getBody();
//
//        return "Handling submitted data";
//    }
}