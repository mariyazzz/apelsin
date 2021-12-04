<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('administration', 'Добавление пользователя');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-create">

    <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
