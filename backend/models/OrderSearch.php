<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use yii\helpers\BaseJson;

/**
 * OrderSearch represents the model behind the search form of `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_manager', 'id_customer', 'is_paid', 'status'], 'integer'],
            [['c_fio', 'c_email', 'c_tel', 'o_address', 'o_city', 'o_comments', 'o_payment', 'o_shipping', 'o_total', 'ip', 'created_at', 'updated_at'], 'safe'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'       => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'          => $this->id,
            'id_manager'  => $this->id_manager,
            'id_customer' => $this->id_customer,
            'is_paid'     => $this->is_paid,
            'status'      => $this->status,
        ]);

        $query->andFilterWhere(['like', 'c_fio', $this->c_fio])
            //->andFilterWhere(['like', 'c_email', $this->c_email])
            ->andFilterWhere(['like', 'c_tel', $this->c_tel])
            ->andFilterWhere(['like', 'o_address', $this->o_address])
            ->andFilterWhere(['like', 'o_city', $this->o_city])
            ->andFilterWhere(['like', 'o_comments', $this->o_comments])
            ->andFilterWhere(['like', 'o_payment', $this->o_payment])
            ->andFilterWhere(['like', 'o_shipping', $this->o_shipping])
            ->andFilterWhere(['like', 'o_total', $this->o_total])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        if ($this->created_at) {
            $query->andFilterWhere(['like', 'created_at', date('Y-m-d', strtotime($this->created_at))]);
        }
        if ($this->updated_at) {
            $query->andFilterWhere(['like', 'updated_at', date('Y-m-d', strtotime($this->updated_at))]);
        }


        return $dataProvider;
    }
}
