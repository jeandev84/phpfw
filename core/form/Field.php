<?php
namespace app\core\form;


use app\core\Model;

/**
 * Class Field
 * @package app\core\form
*/
class Field
{

     public Model $model;
     public string $attribute;



     /**
      * Field constructor.
      * @param Model $model
      * @param $attribute
     */
     public function __construct(Model $model, $attribute)
     {
         $this->model = $model;
         $this->attribute = $attribute;
     }


     public function __toString()
     {
          return sprintf('<div class="col">
            <div class="form-group">
                <label>%s</label>
                <input type="text" name="%s"  value="%s" class="form-control%s">
            </div>
        </div>',
        $this->attribute,
        $this->attribute,
        $this->model->{$this->attribute}
          );
     }
}