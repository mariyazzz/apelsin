<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User {
  public $fullname;

  public $locale;

  public $role;

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['id'], 'integer'],
      [['username', 'email', 'fullname', 'locale', 'role'], 'safe'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function scenarios() {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  /**
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params) {
    $query = User::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'id'                  => $this->id,
      'is_deleted'          => $this->is_deleted,
      'user_profile.locale' => $this->locale,
    ]);
    $query->joinWith(['userProfile']);

    $query->andFilterWhere(['like', 'email', $this->email])
      ->andFilterWhere(['like', 'username', $this->username])
      ->andFilterWhere(['like', 'user_profile.fullname', $this->fullname]);
    if (!empty($this->role)) {
      $query->join('INNER JOIN', 'auth_assignment', 'auth_assignment.user_id = id');
      $query->andFilterWhere([
        'auth_assignment.item_name' => $this->role,
      ]);
    }

    return $dataProvider;
  }

  public function roleList() {
    $list = [];
    foreach (Yii::$app->authManager->getRoles() as $role) {
      $list[$role->name] = Yii::t('role', $role->name);
    }
    return $list;
  }
}
