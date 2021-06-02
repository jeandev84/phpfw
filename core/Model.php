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
     public const RULE_MATCH    = 'match';    // compare data
     public const RULE_UNIQUE   = 'unique';   // unique


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



     public function getLabel($attribute)
     {
         return $this->labels()[$attribute] ?? $attribute;
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
                      $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                     $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                     $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                 }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className  = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName  = $className::tableName();

                    $statement = Application::$app->db->prepare(
                        "SELECT * FROM $tableName WHERE $uniqueAttr = :attr"
                    );

                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, [
                            'field' => $this->getLabel($attribute)
                        ]);
                    }
                }
             }
         }

         return empty($this->errors);
     }


     /**
      * @param string $attribute
      * @param string $ruleName
      * @param array $params
     */
     private function addErrorForRule(string $attribute, string $ruleName, $params = [])
     {
         $message = $this->errorMessages()[$ruleName] ?? '';

         foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
         }

         $this->errors[$attribute][] = $message;
     }



    /**
     * @param string $attribute
     * @param string $message
     * @param array $params
     */
    public function addError(string $attribute, string $message)
    {
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
             self::RULE_UNIQUE   => 'Record with this {field} already exist.',
         ];
     }


     public function labels()
     {
         return [];
     }

     abstract public function rules(): array;
}