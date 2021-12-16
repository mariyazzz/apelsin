<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
  public $basePath = '@webroot';

  public $baseUrl = '@web';

  public $css = [
    'https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900',
    '/css/global.css',
    'css/site.css',
    'css/fonts.css',
    'css/style.css',
  ];

  public $js = [
    'js/core.min.js',
    'js/html5shiv.min.js',
    'js/pointer-events.min.js',
    'js/script.js',
  ];

  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
    'yii\web\JqueryAsset',
  ];
}