<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
      $this->layout = 'empty';
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
   * @return string
   */
  public function actionIndex() {
    return $this->redirect('user');
  }
}