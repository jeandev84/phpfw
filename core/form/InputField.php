<?php
namespace app\core\form;


use app\core\Model;

/**
 * Class InputField
 * @package app\core\form
*/
class InputField extends BaseField
{

     public const TYPE_TEXT = 'text';
     public const TYPE_PASSWORD = 'password';
     public const TYPE_NUMBER = 'number';
     public const TYPE_EMAIL = 'email';


     public string $type;


     /**
      * Field constructor.
      * @param Model $model
      * @param $attribute
     */
     public function __construct(Model $model, $attribute)
     {
         $this->type = self::TYPE_TEXT;
         parent::__construct($model, $attribute);
     }


     public function passwordField()
     {
         $this->type = self::TYPE_PASSWORD;
         return $this;
     }


     /**
      * @return string
     */
     public function renderInput(): string
     {
         return sprintf(
             '<input type="%s" name="%s"  value="%s" class="form-control%s">',
             $this->type,
                     $this->attribute,
                     $this->model->{$this->attribute},
                      $this->model->hasError($this->attribute) ? ' is-invalid' : '',
          );
     }
}