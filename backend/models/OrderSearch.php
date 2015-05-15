<?php namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderSearch extends Order {

  public $keyword;

  public function rules() {
    return [
      [['id', 'created_at', 'updated_at'], 'integer'],
      [['keyword', 'phone', 'email', 'notes', 'status'], 'safe'],
    ];
  }
  public function scenarios() {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }
  public function search($params) {
    $query = Order::find()->orderBy('id DESC');
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);
    if (!($this->load($params) && $this->validate())) {
      return $dataProvider;
    }
    if($this->keyword) {
    // if(preg_match("/[A-Za-zА-Яа-я1-9]+/", $this->keyword) == true) {
      $query->andFilterWhere(['like', 'LOWER(CONCAT(`phone`, `email`, `notes`, `status`))', strtolower($this->keyword)]);
    // }
    }
    return $dataProvider;
  }
}
