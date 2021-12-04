<?php

namespace app\modules\administration\controllers;

use app\models\MultiModel;
use app\models\User;
use app\models\UserProfile;
use app\models\UserSearch;
use app\modules\user\models\AccountForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
      'verbs' => [
        'class'   => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all User models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new UserSearch();
    $searchModel->is_deleted = 0;

    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel'  => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Updates an existing User model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param string $id
   * @return mixed
   */
  public function actionUpdate($id) {
    $accountForm = new AccountForm();
    $accountForm->setUser($this->findModel($id));
    $accountForm->setScenario('admin');

    $model = new MultiModel([
      'models' => [
        'account' => $accountForm,
        'profile' => $accountForm->getUser()->userProfile,
      ],
    ]);

    if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
      return $this->redirect('index');
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Creates a new User model.
   * If creation is successful, the browser will be redirected to the 'index' page.
   * @return mixed
   */
  public function actionCreate() {
    $accountForm = new AccountForm();
    $accountForm->setUser(new User());
    $accountForm->setScenario('admin');
    $profile = new UserProfile();

    $model = new MultiModel([
      'models' => [
        'account' => $accountForm,
        'profile' => $profile,
      ],
    ]);

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      $model->getModels()['account']->save();
      $user_id = $model->getModels()['account']->user->id;
      $model->getModels()['profile']->user_id = $user_id;
      $model->getModels()['profile']->save();

      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing User model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
  public function actionDelete($id) {
    $model = $this->findModel($id);
    $model->is_deleted = 1;
    $model->save(false);

    return $this->redirect(['index']);
  }

  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
