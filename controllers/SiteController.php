<?php

namespace app\controllers;

use app\models\CalculateForm;
use app\modules\user\models\LoginForm;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends Controller {
  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only'  => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow'   => true,
            'roles'   => ['@'],
          ],
        ],
      ],
      'verbs'  => [
        'class'   => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  public function beforeAction($action) {
    if ($action->id == 'error') {
      $this->layout = 'main';
    }

    return parent::beforeAction($action);
  }

  /**
   * @inheritdoc
   */
  public function actions() {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string | Response | array
   */
  public function actionIndex() {
    $form_model = new LoginForm();
    if (\Yii::$app->request->isAjax) {
      $form_model->load($_POST);
      \Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate($form_model);
    }
    if ($form_model->load(\Yii::$app->request->post()) && $form_model->login()) {
      return $this->goBack();
    } else {
      return $this->render('index', [
        'form_model' => $form_model,
      ]);
    }
  }

  public function actionCalculate() {
    $model = new CalculateForm();
    if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate()) {
      $model->calculate();
    }
    return $this->render('calculate', [
      'model' => $model,
    ]);
  }
}