<?php
namespace app\core;


/**
 * Class Model
 * @package app\core
*/
abstract class Model
{

     public const RULE_REQUIRED = 'required'; // not blank
     public const RULE_EMAIL    = 'email';    // valid email address
     public const RULE_MIN      = 'min';      // min length
     public const RULE_MAX      = 'max';      // max length
     public const RULE_MATCH    = 'match';    // unique



    public array $errors = [];


     /**
      * @param $data
     */
     public function loadData($data)
     {
         // populate data and verify in key exist in properties model
         foreach ($data as $key => $value) {
             if (property_exists($this, $key)) {
                 $this->{$key} = $value;
             }
         }
     }


     /**
      * @return bool
     */
     public function validate()
     {
         foreach ($this->rules() as $attribute => $rules) {
             $value = $this->{$attribute};
             foreach ($rules as $rule) {
                $ruleName = $rule;
                if(! is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                      $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                     $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                     $this->addError($attribute, self::RULE_MAX, $rule);
                 }

                if ($ruleName == self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
             }
         }

         return empty($this->errors);
     }


     /**
      * @param string $attribute
      * @param $ruleName
      * @param array $params
    */
     public function addError(string $attribute, $ruleName, $params = [])
     {
         $message = $this->errorMessages()[$ruleName] ?? '';

         foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
         }

         $this->errors[$attribute][] = $message;
     }


     /**
      * @param $attribute
      * @return bool
     */
     public function hasError($attribute)
     {
         /* return \array_key_exists($attribute, $this->errors); */

         return $this->errors[$attribute] ?? false;
     }


     /**
      * @param $attribute
      * @return mixed|string
     */
     public function getFirstError($attribute)
     {
         return $this->errors[$attribute][0] ?? '';
     }


     /**
      * @return string[]
     */
     public function errorMessages()
     {
         return [
             self::RULE_REQUIRED => 'This field is required.',
             self::RULE_EMAIL    => 'This field must be valid email address',
             self::RULE_MIN      => 'Min length of this field must be {min}',
             self::RULE_MAX      => 'Max length of this field must be {max}',
             self::RULE_MATCH    => 'This field must be the same as {match}',
         ];
     }


     abstract public function rules(): array;
}