<?php

namespace app\modules\user\models;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Account form
 */
class AccountForm extends Model {
  public $id;

  public $username;

  public $email;

  public $password;

  public $password_confirm;

  public $role;

  /**
   * @var User
   */
  private $user;

  public function setUser($user) {
    $this->id = $user->id;
    foreach (Yii::$app->authManager->getRolesByUser($user->id) as $role) {
      $this->role = $role->name;
    }
    $this->user = $user;
    $this->email = $user->email;
    $this->username = $user->username;
  }

  public function getUser() {
    return $this->user;
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    $user = $this;
    return [
      ['username', 'filter', 'filter' => 'trim'],
      ['username', 'required'],
      [
        'username',
        'unique',
        'targetClass' => '\app\models\User',
        'message'     => Yii::t('user', 'Это имя пользователя занято.'),
        'filter'      => function($query) use ($user) {
          $query->andWhere(['not', ['id' => $user->id]]);
        },
      ],
      ['username', 'string', 'min' => 1, 'max' => 255],
      ['email', 'filter', 'filter' => 'trim'],
      ['email', 'required'],
      ['email', 'email'],
      [
        'email',
        'unique',
        'targetClass' => '\app\models\User',
        'message'     => Yii::t('user', 'Этот email занят.'),
        'filter'      => function($query) use ($user) {
          $query->andWhere(['not', ['id' => $user->id]]);
        },
      ],
      ['password', 'string'],
      ['password', 'required'],
      [
        'password_confirm',
        'required',
        'when'       => function($model) {
          return !empty($model->password);
        },
        'whenClient' => new JsExpression("function (attribute, value) {
                    return $('#caccountform-password').val().length > 0;
                }"),
      ],
      ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],
      [
        ['role'],
        'in',
        'range' => ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name'),
        'on'    => 'admin',
      ],
    ];
  }

  public function attributeLabels() {
    return [
      'username'         => Yii::t('user', 'Имя пользователя'),
      'email'            => Yii::t('user', 'Email'),
      'password'         => Yii::t('user', 'Пароль'),
      'password_confirm' => Yii::t('user', 'Подтверждение пароля'),
      'role'             => Yii::t('user', 'Роль'),
    ];
  }

  public function save() {
    $this->user->username = $this->username;
    $this->user->email = $this->email;
    if ($this->password) {
      $this->user->setPassword($this->password);
    }

    $isUserSaved = $this->user->save();
    $this->addErrors($this->user->errors);

    if ($isUserSaved) {
      $auth = Yii::$app->authManager;
      $auth->revokeAll($this->user->getId());

      if (!empty($this->role)) {
        $auth->assign($auth->getRole($this->role), $this->user->getId());
      }
    }

    return $isUserSaved;
  }

  public function roleList() {
    $list = [];
    foreach (Yii::$app->authManager->getRoles() as $role) {
      $list[$role->name] = Yii::t('role', $role->name);
    }
    return $list;
  }
}
