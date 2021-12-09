
 <h4 class="title_contact">
        Если остались какие-то вопросы, оставьте контакты. Мы вам перезвоним!
</h4>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Yii;




$form = ActiveForm::begin([
    'id'=>'form-id',
    'options'=>['class'=>'form-class'],
 ])   ?>

    <?= $form->field($model,'surname')->label('Фамилия');?>
    <?= $form->field($model,'name')->label('Имя');?>
    <?= $form->field($model,'tel')->label('Ваш телефон');?>
    <?= $form->field($model,'mail')->label('Почта');?>
    <?=$form->field($model, 'checkboxList')
    ->checkboxList([
        'a' => 'Согласие на обработку персональных данных',
        
    ])->label(' ');?>
    <?= Html::submitButton('Ok',['class'=>'btn btn-primary']) ?>
    <?php ActiveForm::end()?>




