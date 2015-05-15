<?php

namespace common\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\user\models\User;

class UserSearch extends User {

  public $keyword;

  public function rules() {
    return [
      [['id', 'created_at', 'updated_at', 'role'], 'integer'],
      [['keyword','username', 'auth_key', 'password_hash', 'role'], 'safe'],
    ];
  }

  public function scenarios() {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  /**
   * Creates data provider instance with search query applied
   * @param array $params
   * @return ActiveDataProvider
   */
  public function search($params) {
    $query = User::find();
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);
    $this->load($params);
    if (!$this->validate()) {
      // uncomment the following line if you do not want to any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
    if($this->keyword) {
      if(preg_match("/[A-Za-z]+/", $this->keyword) == true) {
        $query->andFilterWhere(['like', 'LOWER(CONCAT(`username`))', strtolower($this->keyword)]);
      } else {
        $query->andFilterWhere([
          'id' => $this->keyword,
        ]);
      }
    }
    $query->andFilterWhere([
      'id' => $this->id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ]);
    $query->andFilterWhere(['like', 'username', $this->username])
      ->andFilterWhere(['like', 'auth_key', $this->auth_key])
      ->andFilterWhere(['like', 'password_hash', $this->password_hash]);
    return $dataProvider;
  }

}
