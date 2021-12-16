<?php

namespace app\modules\user\controllers;

use app\modules\user\models\LoginForm;
use app\modules\user\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignInController extends \yii\web\Controller {
  public $layout = '@app/views/layouts/main';

  /**
   * @return array
   */
  public function actions() {
    return [
      'oauth' => [
        'class'           => 'yii\authclient\AuthAction',
        'successCallback' => [$this, 'successOAuthCallback'],
      ],
    ];
  }

  /**
   * @return array
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'actions' => [
              'signup', 'login', 'oauth',
            ],
            'allow'   => true,
            'roles'   => ['?'],
          ],
          [
            'actions'      => [
              'signup', 'login', 'oauth',
            ],
            'allow'        => false,
            'roles'        => ['@'],
            'denyCallback' => function() {
              return Yii::$app->controller->redirect(['/user/default/index']);
            },
          ],
          [
            'actions' => ['logout'],
            'allow'   => true,
            'roles'   => ['@'],
          ],
        ],
      ],
    ];
  }

  /**
   * @return array|string|Response
   */
  public function actionLogin() {
    $model = new LoginForm();
    if (Yii::$app->request->isAjax) {
      $model->load($_POST);
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate($model);
    }
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    return $this->goHome();
  }

  /**
   * @return Response
   */
  public function actionLogout() {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  /**
   * @return string|Response
   */
  public function actionSignup() {
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if (!$model->validate()) {
        return $this->render('signup', [
          'model' => $model,
        ]);
      }
      $user = $model->signup(Yii::$app->request->post()['SignupForm']);
      if ($user) {
        Yii::$app->getUser()->login($user);
        return $this->goHome();
      }
    }

    return $this->render('signup', [
      'model' => $model,
    ]);
  }
}
