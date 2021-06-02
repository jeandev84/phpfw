<?php
namespace app\models;


use app\core\Application;
use app\core\Model;


/**
 * Class LoginForm
 * @package app\models
*/
class LoginForm extends Model
{

    public string $email = '';
    public string $password = '';


    /**
     * @return array[]
    */
    public function rules(): array
    {
        return [
            'email'    => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }


    public function labels()
    {
        return [
            'email'    => 'Your email',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if (! $user) {
           $this->addError('email', 'User does not exist with this email address.');
           return false;
        }

        /* password_verify(plainPassword, hashedPassword) */
        if (! password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect.');
            return false;
        }

        /* dd($user); */
        return Application::$app->login($user);
    }
}