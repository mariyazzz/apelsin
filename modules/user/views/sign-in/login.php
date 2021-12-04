<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\LoginForm */
$this->title = 'Login';
?>

<?php $form = ActiveForm::begin([
  'id'          => 'login-form',
  'fieldConfig' => [
    'template'     => "{input}{error}",
    'inputOptions' => ['class' => 'form-control'],
    'enableLabel'  => false,
  ],
  'options'     => [
    'class' => 'sign-in-form',
  ],
]); ?>
    <div class="panel panel-body login-form">
        <div class="text-center">
            <div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
            <h5 class="content-group-lg"><?php Yii::t('login', 'Вход в админку'); ?></h5>
        </div>

        <div class="form-group has-feedback has-feedback-left">
          <?php echo $form->field($model, 'identity')
            ->textInput(['placeholder' => Yii::t('login', 'Логин')]) ?>
            <div class="form-control-feedback">
                <i class="icon-user text-muted"></i>
            </div>
        </div>

        <div class="form-group has-feedback has-feedback-left">
          <?php echo $form->field($model, 'password')
            ->passwordInput(['placeholder' => Yii::t('login', 'Пароль')]) ?>
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
        </div>

        <div class="form-group login-options">
            <div class="row">
                <div class="col-sm-6">
                    <label class="checkbox-inline">
                        <div class="checker">
                            <span class="checked">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            </span>
                        </div>
                      <?php echo Yii::t('login', 'Запомнить'); ?>
                    </label>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="<?php echo \yii\helpers\Url::to(['sign-in/request-password-reset']); ?>">
                        <small>
                          <?php Yii::t('login', 'Забыл пароль?'); ?>
                        </small>
                    </a>
                </div>
            </div>
        </div>

        <div class="form-group">
          <?= Html::submitButton(
            Yii::t('login', 'Войти') . ' <i class="icon-circle-right2 position-right"></i>',
            ['class' => 'btn bg-blue btn-block', 'name' => 'login-button']) ?>
        </div>

        <div class="content-divider text-muted form-group">
            <span>
                <?php echo Yii::t('login', 'Нет аккаунта?') ?>
            </span>
        </div>
      <?php echo Html::a(Yii::t('login', 'Регистрация'), ['signup'], [
        'class' => 'btn bg-slate btn-block content-group',
      ]) ?>
    </div>
<?php ActiveForm::end(); ?>