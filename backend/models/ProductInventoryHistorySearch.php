<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductInventoryHistory;

/**
 * ProductInventoryHistorySearch represents the model behind the search form of `common\models\ProductInventoryHistory`.
 */
class ProductInventoryHistorySearch extends ProductInventoryHistory
{
    public $product;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_product', 'id_order', 'id_user', 'status_prev', 'status_new', 'quantity_prev', 'quantity_new'], 'integer'],
            [['created_at', 'updated_at', 'product'], 'safe'],
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
        $query = ProductInventoryHistory::find();

        $query->joinWith(['product']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 200,
            ],
            'sort'       => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['product'] = [
            'asc'  => ['product.name' => SORT_ASC],
            'desc' => ['product.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'            => $this->id,
            'id_product'    => $this->id_product,
            'id_order'      => $this->id_order,
            'id_user'       => $this->id_user,
            'status_prev'   => $this->status_prev,
            'status_new'    => $this->status_new,
            'quantity_prev' => $this->quantity_prev,
            'quantity_new'  => $this->quantity_new,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ]);
        $query->andFilterWhere(['OR',
                                ['like', 'product.name', $this->product],
                                ['like', 'product.upc', $this->product],
        ]);

        return $dataProvider;
    }
}
