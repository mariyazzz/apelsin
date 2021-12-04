<?php

namespace app\modules\user;

class Module extends \yii\base\Module {
  /**
   * @var bool Is users should be activated by email
   */
  public $shouldBeActivated = false;
}
