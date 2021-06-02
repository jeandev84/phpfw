<?php
namespace app\core\form;


use app\core\Model;

/**
 * Class BaseField
 * @package app\core\form
*/
abstract class BaseField
{

    public string $type;
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
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                 %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }


    abstract public function renderInput(): string;

}