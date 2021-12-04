<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\user\models\ResetPasswordForm */
$this->title = 'Password reset';
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
  'id'          => 'password-reset-form',
  'fieldConfig' => [
    'template'     => "{label}{input}{error}",
    'inputOptions' => ['class' => 'form-control'],
  ],
  'options'     => [
    'class' => 'login-form',
  ],
]); ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'password2')->passwordInput() ?>
<div class="form-group">
  <?= Html::submitButton('Save', ['class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
</div>
<?php ActiveForm::end(); ?>
