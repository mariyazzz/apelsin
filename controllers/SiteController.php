<?php

namespace app\controllers;

use app\models\CalculateForm;
use app\models\ContactForm;
use app\models\Recipe;
use app\models\RecipeSearch;
use app\modules\user\models\LoginForm;
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
        'only'  => ['logout', 'calculate'],
        'rules' => [
          [
            'actions' => ['logout', 'calculate'],
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

  public function actionContact() {
    $model = new ContactForm();
    if ($model->load(\Yii::$app->request->post())) {
      if ($model->validate()) { //если валидация пройдена
        $file_name = dirname(__DIR__) . '/user.txt';

        if (file_exists($file_name)) {  //если такой файл существует
          $file = fopen($file_name, 'a+');  //открыть его
          fwrite($file, "Фамилия: " . $model->surname . "\n"); //записать данные
          fwrite($file, "Имя: " . $model->name . "\n");
          fwrite($file, "Телефон: " . $model->tel . "\n");
          fwrite($file, "Почта: " . $model->mail . "\n");
          fclose($file); //закрыть
        }

      }

    }

    return $this->render('contact', compact('model'));

  }

  public function actionRecipe() {
    $id = \Yii::$app->request->get('id');
    if ($id) {
      $model = Recipe::findOne($id);
      return $this->render('recipe_view', [
        'model' => $model,
      ]);
    }


    $searchModel = new RecipeSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('recipe', [
      'dataProvider' => $dataProvider,
    ]);
  }

   public function actionNews()
   {
       return $this->render('news');
   }
}
