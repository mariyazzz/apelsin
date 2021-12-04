<?php

namespace app\modules\administration;

use yii\web\ForbiddenHttpException;

class Module extends \yii\base\Module {
  public function beforeAction($action) {
    if (!\Yii::$app->user->can(\app\models\User::ROLE_ADMINISTRATOR)) {
      throw new ForbiddenHttpException('Access denied');
    }
    return parent::beforeAction($action);
  }
}
