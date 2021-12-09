<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Yii;

?>
<div class="site-calculate">
    <h1><?= Html::encode($this->title) ?></h1>
 <!-- Верхний шаблон-->
 <section class="breadcrumbs-custom" style="background: url(&quot;images/orange_calculate.jpg&quot;); background-size: cover;">
          <div class="container">
            <p class="breadcrumbs-custom-subtitle"></p>
            <p class="heading-1 breadcrumbs-custom-title">Калькулятор - твой друг!</p>
          </div>
        </section>

      </header>
      <!-- hi, we are brave-->
      <section class="section section-lg bg-default">
        <div class="container container-bigger">
          <div class="row row-50 justify-content-md-center align-items-lg-center justify-content-xl-between flex-lg-row-reverse">
            <div class="col-md-10 col-lg-6 col-xl-5">
              <h3>Для чего нужен калькулятор калорий?</h3>
              
              <p class="heading-5">Основной ошибкой при желании привести себя в форму является резкое ограничение калорийности рациона. Соответственно возникает закономерный вопрос — сколько же ккал необходимо получать, чтобы начать худеть?</p>
              <p class="text-spacing-sm">Все люди отличаются друг от друга и у всех организмы обладают индивидуальными особенностями, поэтому для каждого человека нужно свое количество калорий в день для похудения или поддержания веса. 
                  Для определения своей нормы калорий в день рекомендуется использовать формулу Харриса-Бенедикта.</p>
            </div>
           <div class="col-md-10 col-lg-6"><img src="images/calculate.jpg" alt="" width="720" height="459"/> 
            </div>
          </div>
        </div>
      </section>

      
        <div class="section-wrap-inner">
          <div class="container container-bigger">
            <div class="row row-fix row-50">
              <div class="col-lg-8 col-xl-7">
                <div class="section-wrap-content section-lg">
                  <h3>Как пользоваться?</h3>
                  <p class="big">По завершении расчетов суточной нормы калорий по формуле Харриса-Бенедикта у вас появилась точная цифра. Если вашей целью является похудение, то калорий нужно употреблять меньше, чем итоговая цифра (но не меньше 1200 ккал, так как это вредно для здоровья). 
                      Если ваша цель поправиться, то нужно кушать больше, чем полученная цифра. Для сохранения веса кушайте столько продуктов,
                       чтобы выходила полученная сумма калорий. Во всех вариантах желательно делать хоть легкие физические упражнения пару раз в неделю.</p>
                 
                </div>
                <p class="big">Обратите внимание, что формулу Харриса-Бенедикта нельзя применять очень полным людям (формула переоценивает их действительную потребность в калориях)
                     и очень накачанным (формула недооценивает их действительные потребности). </p>
               <!-- <div class=""><img src="images/" alt="" width="720" height="459"/>  -->
                </div>
            </div>
          </div>
         
        </div>



<div class="calculate">
                <h4 class="title_contact">
        Рассчитай свою норму прямо сейчас!
</h4>

<?php





$form = ActiveForm::begin([
    'id'=>'form-id',
    'options'=>['class'=>'form1-class'],
 ])   ?>

    <?= $form->field($model,'age')->label('Возраст');?>
    <?= $form->field($model,'growth')->label('Рост в см');?>
    <?= $form->field($model,'weight')->label('Вес в кг');?>
    <?= $form->field($model,'gender')->radioList (['1'=>'Женский','2'=>'Мужской'])->label('Выберите Ваш пол:');?>
    <?= $form->field($model, 'active_doing')->label('Физическая активность')->dropDownList([
    '0' => 'Сидячий',
    '1' => 'Слегка активный',
    '2' => 'Умеренно активный',
    '3' => 'Очень активный',
    '4' => 'Экстремально активный',
]);?>
    <?= Html::submitButton('Ok',['class'=>'btn btn-primary']) ?>
    <?php ActiveForm::end()?>  
   
</div>
    </div>



