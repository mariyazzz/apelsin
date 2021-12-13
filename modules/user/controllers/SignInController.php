<?php

namespace app\modules\user\controllers;

use app\commands\SendEmailCommand;
use app\models\User;
use app\modules\user\models\LoginForm;
use app\modules\user\models\PasswordResetRequestForm;
use app\modules\user\models\ResetPasswordForm;
use app\modules\user\models\SignupForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
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
              'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation',
            ],
            'allow'   => true,
            'roles'   => ['?'],
          ],
          [
            'actions'      => [
              'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation',
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
    } else {
      return $this->render('login', [
        'model' => $model,
      ]);
    }
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
        if ($model->shouldBeActivated()) {
          Yii::$app->getSession()->setFlash('alert', [
            'body'    => Yii::t(
              'user',
              'Your account has been successfully created. Check your email for further instructions.'
            ),
            'options' => ['class' => 'alert-success'],
          ]);
        } else {
          Yii::$app->getUser()->login($user);
        }
        return $this->goHome();
      }
    }

    return $this->render('signup', [
      'model' => $model,
    ]);
  }

  /**
   * @return string|Response
   */
  public function actionRequestPasswordReset() {
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->getSession()->setFlash('alert', [
          'body'    => Yii::t('user', 'Проверьте email и следуйте инструкциям.'),
          'options' => ['class' => 'alert-success'],
        ]);

        return $this->goHome();
      } else {
        Yii::$app->getSession()->setFlash('alert', [
          'body'    => Yii::t('user', 'Не получилось отправить email для сброса пароля.'),
          'options' => ['class' => 'alert-danger'],
        ]);
      }
    }

    return $this->render('requestPasswordResetToken', [
      'model' => $model,
    ]);
  }

  /**
   * @param $token
   * @return string|Response
   * @throws BadRequestHttpException
   */
  public function actionResetPassword($token) {
    try {
      $model = new ResetPasswordForm($token);
    } catch (InvalidParamException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
      Yii::$app->getSession()->setFlash('alert', [
        'body'    => Yii::t('user', 'Новый пароль сохранён.'),
        'options' => ['class' => 'alert-success'],
      ]);
      return $this->goHome();
    }

    return $this->render('resetPassword', [
      'model' => $model,
    ]);
  }

  /**
   * @param $client \yii\authclient\BaseClient
   * @return bool
   * @throws Exception
   */
  public function successOAuthCallback($client) {
    // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
    $attributes = $client->getUserAttributes();
    $user = User::find()->where([
      'oauth_client'         => $client->getName(),
      'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id'),
    ])
      ->one();
    if (!$user) {
      $user = new User();
      $user->scenario = 'oauth_create';
      $user->username = ArrayHelper::getValue($attributes, 'login');
      $user->email = ArrayHelper::getValue($attributes, 'email');
      $user->oauth_client = $client->getName();
      $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
      $password = Yii::$app->security->generateRandomString(8);
      $user->setPassword($password);
      if ($user->save()) {
        $profileData = [];
        if ($client->getName() === 'facebook') {
          $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
          $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
        }
        $user->afterSignup($profileData);
        $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
          'view'    => 'oauth_welcome',
          'params'  => ['user' => $user, 'password' => $password],
          'subject' => Yii::t('user', '{app-name} | Информация для входа', ['app-name' => Yii::$app->name]),
          'to'      => $user->email,
        ]));
        if ($sentSuccess) {
          Yii::$app->session->setFlash(
            'alert',
            [
              'options' => ['class' => 'alert-success'],
              'body'    => Yii::t('user', 'Welcome to {app-name}. Email с информацией для входа отправлен на вашу почту.', [
                'app-name' => Yii::$app->name,
              ]),
            ]
          );
        }

      } else {
        // We already have a user with this email. Do what you want in such case
        if ($user->email && User::find()->where(['email' => $user->email])->count()) {
          Yii::$app->session->setFlash(
            'alert',
            [
              'options' => ['class' => 'alert-danger'],
              'body'    => Yii::t('user', 'Пользователь с email {email} уже зарегестирован.', [
                'email' => $user->email,
              ]),
            ]
          );
        } else {
          Yii::$app->session->setFlash(
            'alert',
            [
              'options' => ['class' => 'alert-danger'],
              'body'    => Yii::t('user', 'Ошибка аутентификации.'),
            ]
          );
        }

      };
    }
    if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
      return true;
    } else {
      throw new Exception('Ошибка аутентификации');
    }
  }
}
