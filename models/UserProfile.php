<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property integer $locale
 * @property string  $fullname
 *
 * @property User    $user
 */
class UserProfile extends ActiveRecord {
  const GENDER_MALE   = 1;
  const GENDER_FEMALE = 2;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return '{{%user_profile}}';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['fullname'], 'string', 'max' => 255],
      ['locale', 'default', 'value' => Yii::$app->language],
      ['locale', 'in', 'range' => Yii::$app->params['availableLocales']],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'user_id'  => Yii::t('user', '№'),
      'fullname' => Yii::t('user', 'Полное имя'),
      'locale'   => Yii::t('user', 'Язык'),
    ];
  }

  /**
   * @return User|ActiveQuery
   */
  public function getUser() {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }
}
