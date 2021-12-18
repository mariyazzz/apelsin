<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;

use yii\bootstrap4\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


        <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap rd-navbar-corporate">
          <nav class="rd-navbar" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fullwidth" data-xl-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-md-stick-up-offset="130px" data-lg-stick-up-offset="100px" data-stick-up="true" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true">
            <div class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
            <div class="rd-navbar-top-panel rd-navbar-collapse novi-background">
              <div class="rd-navbar-top-panel-inner">
                <ul class="list-inline">
                  <li class="box-inline list-inline-item"><span class="icon novi-icon icon-md-smaller icon-secondary mdi mdi-phone"></span>
                    <ul class="list-comma">
                      <li><a href="tel:#">8(921)567-88-99</a></li>
                   
                    </ul>
                  </li>
                  <li class="box-inline list-inline-item"><span class="icon novi-icon icon-md-smaller icon-secondary mdi mdi-map-marker"></span><a href="#">Невский проспект, дом 66, г.Санкт-Петербург, Россия</a></li>
                  <li class="box-inline list-inline-item"><span class="icon novi-icon icon-md-smaller icon-secondary mdi mdi-email"></span><a href="mailto:#">Apelsinn@mail.ru</a></li>
                </ul>
                <ul class="list-inline">
                  <li class="list-inline-item"><a class="icon novi-icon icon-sm-bigger icon-gray-1 mdi mdi-facebook" href="#"></a></li>
                  <li class="list-inline-item"><a class="icon novi-icon icon-sm-bigger icon-gray-1 mdi mdi-twitter" href="#"></a></li>
                  <li class="list-inline-item"><a class="icon novi-icon icon-sm-bigger icon-gray-1 mdi mdi-instagram" href="#"></a></li>
                  <li class="list-inline-item"><a class="icon novi-icon icon-sm-bigger icon-gray-1 mdi mdi-google-plus" href="#"></a></li>
                  <li class="list-inline-item"><a class="icon novi-icon icon-sm-bigger icon-gray-1 mdi mdi-linkedin" href="#"></a></li>
                </ul>
              </div>
             
            </div>
            <div class="rd-navbar-inner"> 
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <!-- RD Navbar Toggle-->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand-name" href="<?= \yii\helpers\Url::to(['site/index']) ?>"><img class="logo-default" src="images/orange.png" alt="" width="90" height="40"/><img class="logo-inverse" src="images/logo-inverse-208x46.png" alt="" width="308" height="106"/></a></div>
              </div>
              <div class="rd-navbar-aside-center">
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                  <li> <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>">Главная</a>
                    </li>
                    <li> <a href="<?= \yii\helpers\Url::to(['/site/calculate']) ?>">Калькулятор</a>
                    </li>
                    <li> <a href="<?= \yii\helpers\Url::to(['/site/recipe']) ?>">Рецепты</a>
                    </li>
                    <li> <a href="<?= \yii\helpers\Url::to(['/site/news']) ?>">Полезные советы и новости</a>
                    </li>
                    <li> <a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Контакты</a>
                    </li>
                    </li>
                    
                  </ul>
                </div>
              </div>
            </div>
          </nav>
        </div>


<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</main>


<footer class="section page-footer page-footer-minimal novi-background bg-cover text-center bg-gray-darker">
        <div class="container container-wide">
          <div class="row row-fix justify-content-sm-center align-items-md-center row-30">
            <div class="col-md-10 col-lg-7 col-xl-4 text-xl-left"><a href="<?= \yii\helpers\Url::to(['site/index']) ?>"><img class="inverse-logo" src="images/orange.png" alt="" width="108" height="30"/></a></div>
            <div class="col-md-10 col-lg-7 col-xl-4">
              <p class="right">&#169;&nbsp;<span class="copyright-year"></span> Калькулятор калорий Апельсин &nbsp;by&nbsp;<a href=" ">Мария Задвинская</a></p>
            </div>
            <div class="col-md-10 col-lg-7 col-xl-4 text-xl-right">
              
            </div>
          </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
