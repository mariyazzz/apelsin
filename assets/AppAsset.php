<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
  public $basePath = '@webroot';

  public $baseUrl = '@web';

  public $css = [
    'https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900',
    '/template/css/icons/icomoon/styles.css',
    '/template/css/bootstrap.min.css',
    '/template/css/core.css',
    '/template/css/components.min.css',
    '/template/css/colors.min.css',
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
/*
    '/template/js/plugins/loaders/pace.min.js',
    '/template/js/core/libraries/bootstrap.min.js',
    '/template/js/core/libraries/jquery_ui/core.min.js',
    '/template/js/core/libraries/jquery_ui/effects.min.js',
    '/template/js/core/libraries/jquery_ui/interactions.min.js',
    '/template/js/plugins/loaders/blockui.min.js',
    '/template/js/plugins/media/fancybox.min.js',
    '/template/js/plugins/forms/selects/select2.min.js',
    '/template/js/plugins/ui/moment/moment.min.js',
    '/template/js/plugins/pickers/daterangepicker.js',
    '/template/js/plugins/notifications/sweet_alert.min.js',
    'template/js/plugins/trees/fancytree_all.min.js',
    '/template/js/core/app.js',
*/
  ];

  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}