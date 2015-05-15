<?php namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

class ProductSearch extends Product {

  public $keyword;

  public function rules() {
    return [
      [['keyword', 'id', 'title', 'description', 'price'], 'safe'],
    ];
  }

  public function scenarios() {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  public function search($params) {
    $query = Product::find();
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);
    if (!($this->load($params) && $this->validate())) {
      return $dataProvider;
    }
    if($this->keyword) {
  // if(preg_match("/[A-Za-zА-Яа-я1-9]+/", $this->keyword) == true) {
        $query->andFilterWhere([
          'like',
          'LOWER(CONCAT(`id`,`title`,`description`,`price`))',
          strtolower($this->keyword)
        ]);
  //  }
    }
    return $dataProvider;
  }
}
