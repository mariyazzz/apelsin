<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\user\models\SignupForm */
$this->title = 'Sign up';
?>
<?php $form = ActiveForm::begin([
  'id'          => 'sign-up-form',
  'fieldConfig' => [
    'template'     => "{input}{error}",
    'inputOptions' => [
      'class'       => 'form-control',
      'enableLabel' => false,
    ],
  ],
  'options'     => [
    'class' => 'login-form',
  ],
]); ?>

<div class="panel panel-body login-form">

  <?php echo $form->field($model, 'username')
    ->textInput(['placeholder' => Yii::t('login', 'Логин')]) ?>
  <?php echo $form->field($model, 'email')
    ->textInput(['placeholder' => Yii::t('login', 'Email')]) ?>
  <?php echo $form->field($model, 'fullname')
    ->textInput(['placeholder' => Yii::t('login', 'Имя')]) ?>
  <?php echo $form->field($model, 'password')
    ->passwordInput(['placeholder' => Yii::t('login', 'Пароль')]) ?>
  <?php echo $form->field($model, 'password2')
    ->passwordInput(['placeholder' => Yii::t('login', 'Повтор пароля')]) ?>
    <div class="form-group">
      <?= Html::submitButton(
        Yii::t('login', 'Регистрация') . ' <i class="icon-circle-right2 position-right"></i>',
        ['class' => 'btn bg-blue btn-block', 'name' => 'login-button']) ?>
    </div>
    <div style="text-align: center">Нажимая Регистрация вы соглашаетесь с <a href="/confidential">политикой конфиденциальности</a>.</div>

    <div class="content-divider text-muted form-group">
        <span>
            <?php echo Yii::t('login', 'Уже зарегестрирован?') ?>
        </span>
    </div>

    <div class="form-group">
      <?php echo Html::a(Yii::t('login', 'Войти'), ['login'], [
        'class' => 'btn bg-slate btn-block content-group',
      ]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>