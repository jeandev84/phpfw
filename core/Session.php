<?php
namespace app\core;


/**
 * Class Session
 * @package app\core
*/
class Session
{

    protected const FLASH_KEY = 'flash_messages';


    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be removed
             $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }


    /**
     * @param $key
     * @param $value
    */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    /**
     * @param $key
     * @return array|mixed
    */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }


    /**
     * @param $key
    */
    public function remove($key)
    {
         unset($_SESSION[$key]);
    }


    /**
     * @param $key
     * @param $message
    */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value'   => $message
        ];
    }


    /**
     * @param $key
     * @return false
    */
    public function getFlash($key)
    {
       return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }


    public function __destruct()
    {
        // Iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be removed
            if($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}