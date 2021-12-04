<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstagramProfile */

$this->title = Yii::t('app', 'Create Instagram Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instagram Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
