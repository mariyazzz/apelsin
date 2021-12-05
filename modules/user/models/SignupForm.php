<?php

namespace app\modules\user\models;

use app\commands\SendEmailCommand;
use app\models\User;
use app\models\UserToken;
use app\modules\user\Module;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model {
  /**
   * @var
   */
  public $username;

  /**
   * @var
   */
  public $fullname;

  /**
   * @var
   */
  public $email;

  /**
   * @var
   */
  public $password;

  /**
   * @var
   */
  public $password2;

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['username', 'fullname'], 'filter', 'filter' => 'trim'],
      ['username', 'required'],
      [
        'username',
        'unique',
        'targetClass' => '\app\models\User',
        'message'     => Yii::t('user', 'Это имя пользователя уже занято.'),
      ],
      ['username', 'string', 'min' => 2, 'max' => 255],

      ['email', 'filter', 'filter' => 'trim'],
      ['email', 'required'],
      ['email', 'email'],
      [
        'email',
        'unique',
        'targetClass' => '\app\models\User',
        'message'     => Yii::t('user', 'Пользователь с таким email уже зарегестрирован.'),
      ],

      [['password', 'password2'], 'required'],
      ['password', 'string', 'min' => 6],
      ['password2', 'compare', 'compareAttribute' => 'password'],
    ];
  }

  /**
   * @return array
   */
  public function attributeLabels() {
    return [
      'username'  => Yii::t('user', 'Имя пользователя'),
      'fullname'  => Yii::t('user', 'Полное имя'),
      'email'     => Yii::t('user', 'E-mail'),
      'password'  => Yii::t('user', 'Пароль'),
      'password2' => Yii::t('user', 'Повтор пароля'),
    ];
  }

  /**
   * Signs user up.
   *
   * @return User|null the saved model or null if saving fails
   */
  public function signup($profileData = []) {
    if ($this->validate()) {
      $shouldBeActivated = $this->shouldBeActivated();
      $user = new User();
      $user->username = $this->username;
      $user->email = $this->email;
      $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
      $user->setPassword($this->password);
      if (!$user->save()) {
        return null;
      };
      $user->afterSignup($profileData);
      if ($shouldBeActivated) {
        $token = UserToken::create($user->id, UserToken::TYPE_ACTIVATION, 60*60*24);
        Yii::$app->commandBus->handle(new SendEmailCommand([
          'subject' => Yii::t('user', 'Email активации'),
          'view'    => 'activation',
          'to'      => $this->email,
          'params'  => [
            'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true),
          ],
        ]));
      }

      return $user;
    }

    return null;
  }

  /**
   * @return bool
   */
  public function shouldBeActivated() {
    /** @var Module $userModule */
    $userModule = Yii::$app->getModule('user');
    if (!$userModule) {
      return false;
    } elseif ($userModule->shouldBeActivated) {
      return true;
    } else {
      return false;
    }
  }
}
