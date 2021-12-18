<?php

/* @var $model \app\models\Recipe */
/* @var $this yii\web\View */



?>
<div class="site-recipe">
  <?php
  echo <<<HTML
<div class="recipe_view">
    <h1 class="recipe_view_title">$model->title</h1>
    <img class="recipe_view_img" src="{$model->photo}">
    <div class="recipe_view_text">$model->text</div>
</div>
HTML;

  ?>
   
</div>
