<?php

namespace app\models;

use app\commands\AddToTimelineCommand;
use app\models\query\UserQuery;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer                 $id
 * @property string                  $username
 * @property string                  $password_hash
 * @property string                  $email
 * @property string                  $auth_key
 * @property string                  $access_token
 * @property string                  $oauth_client
 * @property string                  $oauth_client_user_id
 * @property string                  $publicIdentity
 * @property integer                 $status
 * @property integer                 $created_at
 * @property integer                 $updated_at
 * @property integer                 $logged_at
 * @property string                  $password write-only password
 * @property boolean                 $is_deleted
 *
 * @property \app\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface {
  const STATUS_NOT_ACTIVE = 1;
  const STATUS_ACTIVE     = 2;
  const STATUS_DELETED    = 3;

  const ROLE_UNAUTHORIZED  = 'unauthorized';
  const ROLE_USER          = 'user';
  const ROLE_ADMINISTRATOR = 'administrator';

  const EVENT_AFTER_SIGNUP = 'afterSignup';
  const EVENT_AFTER_LOGIN  = 'afterLogin';

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return '{{%user}}';
  }

  /**
   * @return UserQuery
   */
  public static function find() {
    return new UserQuery(get_called_class());
  }

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
      TimestampBehavior::className(),
      'auth_key'     => [
        'class'      => AttributeBehavior::className(),
        'attributes' => [
          ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key',
        ],
        'value'      => Yii::$app->getSecurity()->generateRandomString(),
      ],
      'access_token' => [
        'class'      => AttributeBehavior::className(),
        'attributes' => [
          ActiveRecord::EVENT_BEFORE_INSERT => 'access_token',
        ],
        'value'      => function() {
          return Yii::$app->getSecurity()->generateRandomString(40);
        },
      ],
    ];
  }

  /**
   * @return array
   */
  public function scenarios() {
    return ArrayHelper::merge(
      parent::scenarios(),
      [
        'oauth_create' => [
          'oauth_client',
          'oauth_client_user_id',
          'email',
          'username',
          '!status',
        ],
      ]
    );
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['username', 'email'], 'unique'],
      ['status', 'default', 'value' => self::STATUS_ACTIVE],
      ['status', 'in', 'range' => array_keys(self::statuses())],
      [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'username'     => Yii::t('user', 'Имя пользователя'),
      'email'        => Yii::t('user', 'E-mail'),
      'status'       => Yii::t('user', 'Статус'),
      'access_token' => Yii::t('user', 'API access token'),
      'created_at'   => Yii::t('user', 'Создан'),
      'updated_at'   => Yii::t('user', 'Обновлён'),
      'logged_at'    => Yii::t('user', 'Последний вход'),
      'role'         => Yii::t('user', 'Роль'),
      'fullname'     => Yii::t('user', 'Полное имя'),
      'locale'       => Yii::t('user', 'Язык'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUserProfile() {
    return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
  }

  /**
   * @inheritdoc
   */
  public static function findIdentity($id) {
    return static::find()
      ->active()
      ->andWhere(['id' => $id])
      ->one();
  }

  /**
   * @inheritdoc
   */
  public static function findIdentityByAccessToken($token, $type = null) {
    return static::find()
      ->active()
      ->andWhere(['access_token' => $token])
      ->one();
  }

  /**
   * Finds user by username
   *
   * @param string $username
   * @return static|null
   */
  public static function findByUsername($username) {
    return static::find()
      ->active()
      ->andWhere(['username' => $username])
      ->one();
  }

  /**
   * Finds user by username or email
   *
   * @param string $login
   * @return static|null
   */
  public static function findByLogin($login) {
    return static::find()
      ->active()
      ->andWhere(['or', ['username' => $login], ['email' => $login]])
      ->one();
  }

  /**
   * @inheritdoc
   */
  public function getId() {
    return $this->getPrimaryKey();
  }

  /**
   * @inheritdoc
   */
  public function getAuthKey() {
    return $this->auth_key;
  }

  /**
   * @inheritdoc
   */
  public function validateAuthKey($authKey) {
    return $this->getAuthKey() === $authKey;
  }

  /**
   * Validates password
   *
   * @param string $password password to validate
   * @return boolean if password provided is valid for current user
   */
  public function validatePassword($password) {
    return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
  }

  /**
   * Generates password hash from password and sets it to the model
   *
   * @param string $password
   */
  public function setPassword($password) {
    $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
  }

  /**
   * Returns user statuses list
   * @return array|mixed
   */
  public static function statuses() {
    return [
      self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
      self::STATUS_ACTIVE     => Yii::t('common', 'Active'),
      self::STATUS_DELETED    => Yii::t('common', 'Deleted'),
    ];
  }

  /**
   * Creates user profile and application event
   * @param array $profileData
   */
  public function afterSignup(array $profileData = []) {
    $this->refresh();
    $profile = new UserProfile();
    $profile->locale = Yii::$app->language;
    $profile->load($profileData, '');
    $this->link('userProfile', $profile);
    $this->trigger(self::EVENT_AFTER_SIGNUP);
    // Default role
    $auth = Yii::$app->authManager;
    $auth->assign($auth->getRole(User::ROLE_UNAUTHORIZED), $this->getId());
  }

  /**
   * @return string
   */
  public function getPublicIdentity() {
    if ($this->userProfile && $this->userProfile->fullname) {
      return $this->userProfile->fullname;
    }
    if ($this->username) {
      return $this->username;
    }
    return $this->email;
  }

  /**
   * @param integer $size
   * @return bool|null|string
   */
  public function getAvatar($size = 40) {
    return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=mm' . '&s=' . $size;
  }

  public static function getList($key = 'id') {
    static $list;
    if ($list === null) {
      $list = [];
      $rows = (new \yii\db\Query())
        ->select([$key, 'fullname', 'username', 'email'])
        ->join('INNER JOIN', UserProfile::tableName(), 'user_id = id')
        ->andWhere(['status' => self::STATUS_ACTIVE])
        ->from(self::tableName())
        ->all();
      foreach ($rows as $row) {
        $list[$row[$key]] = '#' . $row[$key] . ' - ' . (empty($row['fullname']) ? $row['username'] : $row['fullname']) . ' (' . $row['email'] . ')';
      }
    }
    return $list;
  }
}