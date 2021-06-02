<?php
  /** @var $this \app\core\View */
  /** @var $model \app\models\ContactForm */

use app\core\form\TextareaField;

$this->title = 'Contact';
?>
<h1>Contact us</h1>

<?php $form = \app\core\form\Form::begin('', 'post') ?>
  <?= $form->field($model, 'subject') ?>
  <?= $form->field($model, 'email') ?>
  <?=  new TextareaField($model, 'body') ?>
  <button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end(); ?>
<!--<form action="" method="post">-->
<!--    <div class="form-group">-->
<!--        <label>Subject</label>-->
<!--        <input type="text" name="subject" class="form-control">-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label>Email</label>-->
<!--        <input type="text" name="email" class="form-control">-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label>Body</label>-->
<!--        <textarea name="body" class="form-control"></textarea>-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary">Submit</button>-->
<!--</form>-->