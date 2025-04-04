<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Income;

/**
 * IncomeSearch represents the model behind the search form of `common\models\Income`.
 */
class IncomeSearch extends Income
{
    public $incomeProductCount;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_vendor', 'id_warehouse', 'incomeProductCount'], 'integer'],
            [['num', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Income::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort'       => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_vendor' => $this->id_vendor,
            'id_warehouse' => $this->id_warehouse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num]);

        return $dataProvider;
    }
}
