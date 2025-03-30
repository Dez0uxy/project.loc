<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'discount', 'type', 'region'], 'integer'],
            [['email', 'lastname', 'firstname', 'middlename', 'birthdate', 'tel', 'tel2', 'company', 'address', 'city', 'automark', 'automodel', 'carrier', 'carrier_city', 'carrier_branch', 'carrier_tel', 'carrier_fio'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort'       => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'discount'  => $this->discount,
            'type'      => $this->type,
            'birthdate' => $this->birthdate,
            'region'    => $this->region,
        ]);

        $query
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'tel2', $this->tel2])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'automark', $this->automark])
            ->andFilterWhere(['like', 'automodel', $this->automodel])
            ->andFilterWhere(['like', 'carrier', $this->carrier])
            ->andFilterWhere(['like', 'carrier_city', $this->carrier_city])
            ->andFilterWhere(['like', 'carrier_branch', $this->carrier_branch])
            ->andFilterWhere(['like', 'carrier_tel', $this->carrier_tel])
            ->andFilterWhere(['like', 'carrier_fio', $this->carrier_fio]);

        return $dataProvider;
    }
}
