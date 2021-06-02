<?php
  /** @var $model \app\models\User */

/* dump(\app\core\Application::$app->user); */
?>
<h1>Login</h1>

<?php $form = \app\core\form\Form::begin("", "post") ?>
<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'password')->passwordField(); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end(); ?>


<!--<form action="" method="post">-->
<!--    <div class="form-group">-->
<!--        <label>Email</label>-->
<!--        <input type="text" name="email" class="form-control">-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label>Password</label>-->
<!--        <input type="text" name="password" class="form-control">-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary">Submit</button>-->
<!--</form>-->