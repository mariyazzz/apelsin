<?php

/* @var $this yii\web\View */
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;



?>
<div class="site-recipe">
    <h1><?= Html::encode($this->title) ?></h1>

    <section class="breadcrumbs-custom" style="background: url(&quot;images/orange_calculate.jpg&quot;); background-size: cover;">
          <div class="container">
            <p class="breadcrumbs-custom-subtitle"></p>
            <p class="heading-1 breadcrumbs-custom-title">Вкусно - полезно!</p>
          </div>
        </section>
    <section>
      <?php

      echo \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'itemView' => function(\app\models\Recipe $model) {
          $id = $model->id;
          $title = $model->title;
          $image = $model->photo;
          return "<div class='recipe'><img class='recipe_image' src='$image'><div class='recipe_title'><a href='/index.php?r=site/recipe&id=$id'>$title</a></div></div>";
        }
      ]);
      ?>
    </section>

   
</div>
