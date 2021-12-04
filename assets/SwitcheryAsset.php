<?php

namespace app\assets;

use yii\web\AssetBundle;

class SwitcheryAsset extends AssetBundle {
  public $css = [
    '/template/css/components.css',
  ];

  public $js = [
    "/template/js/plugins/forms/styling/uniform.min.js",
    "/template/js/plugins/forms/styling/switchery.min.js",
    "/template/js/plugins/forms/styling/switch.min.js",
  ];

  public $depends = [
    'app\assets\AppAsset',
  ];

  public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
