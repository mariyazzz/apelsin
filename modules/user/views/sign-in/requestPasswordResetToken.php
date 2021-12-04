<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\user\models\PasswordResetRequestForm */
$this->title = 'Password reset';
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
  'id'          => 'request-password-reset-form',
  'fieldConfig' => [
    'template'     => "{label}{input}{error}",
    'inputOptions' => ['class' => 'form-control'],
  ],
  'options'     => [
    'class' => 'login-form',
  ],
]); ?>
<?php echo $form->field($model, 'email') ?>
<div class="form-group">
  <?= Html::submitButton('Send', ['class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
</div>

<div class="text-center help-block">
    <p class="text-muted help-block">
        <small>Remember one?</small>
    </p>
</div>

<?php echo Html::a(Yii::t('login', 'Вернуться на страницу входа'), ['login'], [
  'class' => 'btn btn-md btn-default btn-block',
]) ?>
<?php ActiveForm::end(); ?>
