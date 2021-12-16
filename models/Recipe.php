<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $photo
 * @property int|null $calories
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'calories', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['photo'], 'string', 'max' => 200],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'photo' => 'Photo',
            'calories' => 'Calories',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
