<?php

namespace app\components;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class MenuNav extends Menu {

  protected function renderItem($item) {

    if (isset($item['url'])) {
      $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

      return strtr($template, [
        '{url}'       => Html::encode(Url::to($item['url'])),
        '{label}'     => $item['label'],
        '{iconClass}' => isset($item['iconClass']) ? $item['iconClass'] : '',
      ]);
    }

    $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
    return strtr($template, [
      '{label}' => $item['label'],
    ]);
  }
}