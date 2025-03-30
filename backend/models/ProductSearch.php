<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_vendor', 'id_category', 'id_brand', 'id_warehouse', 'id_image', 'prom_export', 'count', 'is_new', 'extra_charge', 'status'], 'integer'],
            [['name', 'url', 'upc', 'weight', 'analog', 'applicable', 'currency', 'ware_place', 'note', 'description', 'meta_keywords', 'meta_description'], 'safe'],
            [['price'], 'number'],
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
        $query = Product::find()->joinWith('productQuantity');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => \Yii::$app->request->cookies->getValue('pageSize', 100),
            ],
            'sort'       => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['price'] = [
            'asc' => ['COALESCE(product_quantity.price, product.price)' => SORT_ASC],
            'desc' => ['COALESCE(product_quantity.price, product.price)' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'product.id'             => $this->id,
            'product.id_vendor'      => $this->id_vendor,
            'product.id_category'    => $this->id_category,
            'product.id_brand'       => $this->id_brand,
            'product.id_warehouse'   => $this->id_warehouse,
            'product.id_image'       => $this->id_image,
            'product.prom_export'    => $this->prom_export,
            'product.count'          => $this->count,
            'product_quantity.price' => $this->price,
            'product.is_new'         => $this->is_new,
            'product.extra_charge'   => $this->extra_charge,
            'product.status'         => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            //->andFilterWhere(['like', 'url', $this->url])
            //->andFilterWhere(['like', 'upc', $this->upc])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'analog', $this->analog])
            ->andFilterWhere(['like', 'applicable', $this->applicable])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'ware_place', $this->ware_place])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description]);

        

       if (!empty($this->upc)) {
            $query->andFilterWhere([
                'OR',
                ['like', 'upc', $this->upc . '%', false],
                ['like', 'analog', '%' . $this->upc . '%', false],
                ['like', 'applicable', '%' . $this->upc . '%', false],
            ]);
        }

        return $dataProvider;
    }
}
