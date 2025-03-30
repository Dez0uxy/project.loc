<?php

namespace backend\models;

use common\models\ActionLog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActionLogSearch represents the model behind the search form of `common\models\ActionLog`.
 */
class ActionLogSearch extends ActionLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_model', 'id_user', 'ipv4'], 'integer'],
            [['table_name', 'action', 'data', 'created_at'], 'safe'],
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
        $query = ActionLog::find();

        // add conditions that should always apply here
        //$query->andWhere(['!=', 'id_user', 1]);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
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
            'id'         => $this->id,
            'id_model'   => $this->id_model,
            'id_user'    => $this->id_user,
            'ipv4'       => $this->ipv4,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
