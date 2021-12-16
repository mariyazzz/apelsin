<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Пользователи');
?>
<div class="panel">
    <div class="panel-heading">
        <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <p> <p>
          <?= Html::a(Yii::t('user', 'Создать Пользователя'), ['create'], ['class' => 'btn btn-success']) ?>
</p> </p>
       <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
          'id',
          'username',
          'email:email',
          'userProfile.fullname' => [
            'attribute' => 'fullname',
            'value'     => function(\app\models\User $data) {
              return $data->userProfile->fullname;
            },
          ],
          'userProfile.locale'   => [
            'attribute' => 'locale',
            'value'     => function(\app\models\User $data) {
              return $data->userProfile->locale;
            },
            'filter'    => array_combine((array)Yii::$app->params['availableLocales'], (array)Yii::$app->params['availableLocales']),
          ],
          'role'                 => [
            'attribute' => 'role',
            'value'     => function(\app\models\User $data) {
              $list = [];
              foreach (Yii::$app->authManager->getRolesByUser($data->id) as $role) {
                $list[] = Yii::t('role', $role->name);
              }
              return implode(', ', $list);
            },
            'filter'    => $searchModel->roleList(),
          ],
          [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons'  => [
              'update' => function($url, $model) {
                return \yii\helpers\Html::a('<span class="icon-pencil"></span>', $url, [
                  'title' => Yii::t('global', '->'),
                  'class' => 'btn btn-info',
                ]);
              },
              'delete' => function($url, $model) {
                return \yii\helpers\Html::a('<span class="icon-trash"></span>', $url, [
                  'title'        => Yii::t('global', 'x'),
                  'data-confirm' => Yii::t('global', 'Вы уверены что хотите удалить?'),
                  'data-method'  => 'post',
                  'class'        => 'btn btn-danger',
                ]);
              },
            ],
          ],
        ],

        'tableOptions' => [
          'class' => 'table  table-hover general-table',
        ],
        'layout'       => "{items}\n{pager}",
      ]); ?>
    </div>
</div>
