<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FilterAuto;

/**
 * FilterAutoSearch represents the model behind the search form of `common\models\FilterAuto`.
 */
class FilterAutoSearch extends FilterAuto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_product'], 'integer'],
            [['vendor', 'model', 'year', 'engine'], 'safe'],
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
        $query = FilterAuto::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort'       => ['defaultOrder' => ['id_product' => SORT_ASC, 'vendor' => SORT_ASC, 'model' => SORT_ASC]],
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
            'id_product' => $this->id_product,
        ]);

        $query->andFilterWhere(['like', 'vendor', $this->vendor])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'engine', $this->engine]);

        return $dataProvider;
    }
}
