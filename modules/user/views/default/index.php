<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'User Settings')
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
              <?php echo Yii::t('user', 'Настройки профиля') ?>
            </header>
            <div class="panel-body">
              <?php echo $form->field($model->getModel('profile'), 'fullname')->textInput(['maxlength' => 255]) ?>

              <?php echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(array_combine(Yii::$app->params['availableLocales'], Yii::$app->params['availableLocales'])) ?>

                <div class="form-group">
                  <?= Html::submitButton(Yii::t('general', 'Сохранить'), ['class' => 'btn btn-success pull-right']) ?>
                </div>
            </div>
        </section>
    </div>
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
              <?php echo Yii::t('user', 'Настройки аккаунта') ?>
            </header>
            <div class="panel-body">
              <?php echo $form->field($model->getModel('account'), 'username') ?>

              <?php echo $form->field($model->getModel('account'), 'email') ?>

              <?php echo $form->field($model->getModel('account'), 'password')->passwordInput() ?>

              <?php echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput() ?>

                <div class="form-group">
                  <?php echo Html::submitButton(Yii::t('global', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </section>
    </div>
</div>
<?php ActiveForm::end(); ?>
