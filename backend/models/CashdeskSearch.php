<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cashdesk;

/**
 * CashdeskSearch represents the model behind the search form of `common\models\Cashdesk`.
 */
class CashdeskSearch extends Cashdesk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_order', 'id_method'], 'integer'],
            [['amount'], 'number'],
            [['note', 'created_at', 'updated_at'], 'safe'],
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
        $query = Cashdesk::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 200,
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
            'id'        => $this->id,
            'id_user'   => $this->id_user,
            'id_order'  => $this->id_order,
            'id_method' => $this->id_method,
            'amount'    => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        if ($this->created_at) {
            $query->andFilterWhere(['like', 'created_at', date('Y-m-d', strtotime($this->created_at))]);
        }
        if ($this->updated_at) {
            $query->andFilterWhere(['like', 'updated_at', date('Y-m-d', strtotime($this->updated_at))]);
        }

        return $dataProvider;
    }
}
