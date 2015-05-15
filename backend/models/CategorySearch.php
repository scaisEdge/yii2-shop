<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{

  public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Category::find()->orderBy('parent_id ASC, id ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
      if($this->keyword) {
        if(preg_match("/[A-Za-z1-9]+/", $this->keyword) == true) {
          $query->andFilterWhere(['like', 'LOWER(CONCAT(`title`,`id`, ))', strtolower($this->keyword)]);
        } else {
          $query->andFilterWhere([
            'id' => $this->keyword,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          ]);
        }
      }
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
