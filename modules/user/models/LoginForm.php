<?php

namespace app\modules\user\models;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {
  public $identity;

  public $password;

  public $rememberMe = true;

  private $user = false;

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      // username and password are both required
      [['identity', 'password'], 'required'],
      // rememberMe must be a boolean value
      ['rememberMe', 'boolean'],
      // password is validated by validatePassword()
      ['password', 'validatePassword'],
    ];
  }

  public function attributeLabels() {
    return [
      'identity'   => Yii::t('user', 'Имя пользователя или пароль'),
      'password'   => Yii::t('user', 'Пароль'),
      'rememberMe' => Yii::t('user', 'Запомнить'),
    ];
  }

  /**
   * Validates the password.
   * This method serves as the inline validation for password.
   */
  public function validatePassword() {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError('password', Yii::t('user', 'Incorrect username or password.'));
      }
    }
  }

  /**
   * Logs in a user using the provided username and password.
   *
   * @return boolean whether the user is logged in successfully
   */
  public function login() {
    if ($this->validate()) {
      if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 60*60*24*30 : 0)) {
        return true;
      }
    }
    return false;
  }

  /**
   * Finds user by [[username]]
   *
   * @return User|null
   */
  public function getUser() {
    if ($this->user === false) {
      $this->user = User::find()
        ->active()
        ->andWhere(['or', ['username' => $this->identity], ['email' => $this->identity]])
        ->one();
    }

    return $this->user;
  }
}
