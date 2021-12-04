<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstagramProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Instagram Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?= Html::a(Yii::t('app', 'Create Instagram Profile'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      'name',
      'is_whitelisted',
      'comment:ntext',
      'add_time:datetime',
      [
        'format'    => 'html',
        'attribute' => 'username',
        'value'     => function($data) {
          return Html::a($data['username'], "https://www.instagram.com/" . $data['username'] . '/', ['target' => '_blank']);
        },
      ],

      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
