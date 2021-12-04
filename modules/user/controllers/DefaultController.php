<?php

namespace app\modules\user\controllers;

use app\models\MultiModel;
use app\modules\user\models\AccountForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller {
  /**
   * @return array
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  /**
   * @return string|\yii\web\Response
   */
  public function actionIndex() {
    $accountForm = new AccountForm();
    $accountForm->setUser(Yii::$app->user->identity);

    $model = new MultiModel([
      'models' => [
        'account' => $accountForm,
        'profile' => Yii::$app->user->identity->userProfile,
      ],
    ]);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      $locale = $model->getModel('profile')->locale;
      Yii::$app->session->setFlash('forceUpdateLocale');
      Yii::$app->session->setFlash('alert', [
        'options' => ['class' => 'alert-success'],
        'body'    => Yii::t('user', 'Ваш аккаунт успешно зарегестрирован', [], $locale),
      ]);
      return $this->refresh();
    }
    return $this->render('index', ['model' => $model]);
  }
}
