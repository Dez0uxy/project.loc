<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NpInternetDocument;

/**
 * NpInternetDocumentSearch represents the model behind the search form of `common\models\NpInternetDocument`.
 */
class NpInternetDocumentSearch extends NpInternetDocument
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Cost', 'SeatsAmount', 'status'], 'integer'],
            [['TrackingNumber', 'senderFirstName', 'senderMiddleName', 'senderLastName', 'senderDescription', 'senderPhone', 'senderCity', 'senderRegion', 'senderCitySender', 'senderSenderAddress', 'senderWarehouse', 'recipientFirstName', 'recipientMiddleName', 'recipientLastName', 'recipientPhone', 'recipientCity', 'recipientRegion', 'recipientWarehouse', 'DateTime', 'ServiceType', 'PaymentMethod', 'Description', 'CargoType', 'BackDelivery_PayerType', 'BackDelivery_CargoType', 'BackDelivery_RedeliveryString', 'created_at', 'updated_at'], 'safe'],
            [['Weight', 'VolumeGeneral'], 'number'],
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
        $query = NpInternetDocument::find();

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
            'id' => $this->id,
            'Cost' => $this->Cost,
            'SeatsAmount' => $this->SeatsAmount,
            'Weight' => $this->Weight,
            'VolumeGeneral' => $this->VolumeGeneral,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'TrackingNumber', $this->TrackingNumber])
            ->andFilterWhere(['like', 'senderFirstName', $this->senderFirstName])
            ->andFilterWhere(['like', 'senderMiddleName', $this->senderMiddleName])
            ->andFilterWhere(['like', 'senderLastName', $this->senderLastName])
            ->andFilterWhere(['like', 'senderDescription', $this->senderDescription])
            ->andFilterWhere(['like', 'senderPhone', $this->senderPhone])
            ->andFilterWhere(['like', 'senderCity', $this->senderCity])
            ->andFilterWhere(['like', 'senderRegion', $this->senderRegion])
            ->andFilterWhere(['like', 'senderCitySender', $this->senderCitySender])
            ->andFilterWhere(['like', 'senderSenderAddress', $this->senderSenderAddress])
            ->andFilterWhere(['like', 'senderWarehouse', $this->senderWarehouse])
            ->andFilterWhere(['like', 'recipientFirstName', $this->recipientFirstName])
            ->andFilterWhere(['like', 'recipientMiddleName', $this->recipientMiddleName])
            ->andFilterWhere(['like', 'recipientLastName', $this->recipientLastName])
            ->andFilterWhere(['like', 'recipientPhone', $this->recipientPhone])
            ->andFilterWhere(['like', 'recipientCity', $this->recipientCity])
            ->andFilterWhere(['like', 'recipientRegion', $this->recipientRegion])
            ->andFilterWhere(['like', 'recipientWarehouse', $this->recipientWarehouse])
            ->andFilterWhere(['like', 'DateTime', $this->DateTime])
            ->andFilterWhere(['like', 'ServiceType', $this->ServiceType])
            ->andFilterWhere(['like', 'PaymentMethod', $this->PaymentMethod])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'CargoType', $this->CargoType])
            ->andFilterWhere(['like', 'BackDelivery_PayerType', $this->BackDelivery_PayerType])
            ->andFilterWhere(['like', 'BackDelivery_CargoType', $this->BackDelivery_CargoType])
            ->andFilterWhere(['like', 'BackDelivery_RedeliveryString', $this->BackDelivery_RedeliveryString]);

        return $dataProvider;
    }
}
