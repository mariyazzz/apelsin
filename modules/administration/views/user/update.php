<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MultiModel */
?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                User #<?= $model->getModel('account')->id ?> - "<?= $model->getModel('profile')->fullname ?>"
                <div class="pull-right">
                  <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
                </div>
            </header>
            <div class="panel-body">
              <?= $this->render('_form', [
                'model' => $model,
              ]) ?>
            </div>
        </section>
    </div>
</div>
