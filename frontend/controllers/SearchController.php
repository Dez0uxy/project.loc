<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\SearchForm;
use common\models\FilterAuto;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class SearchController extends CommonController
{
    public function actionIndex()
    {
        $model = new SearchForm();
        $model->load(Yii::$app->request->queryParams);
        $model->q = trim($model->q);

        $productsDataProvider = false;
        if($model->q) {
            $productsQuery = Product::find()
                ->where(['status' => '1'])
                ->andWhere(['LIKE', 'upc', $model->q, false])
                ->orderBy(['upc'  => SORT_ASC])
                ->limit(20);
            $productsQuery2 = Product::find()
                ->where(['status' => '1'])
                ->andWhere(['OR',
                            ['LIKE', 'name', $model->q],
                            ['LIKE', 'upc', $model->q],
                            ['LIKE', 'analog', $model->q],
                            ['LIKE', 'applicable', $model->q],
                            ['LIKE', 'description', $model->q],
                ])
                ->orderBy(['upc'  => SORT_ASC])
                ->limit(20);

            $productsQuery->union($productsQuery2);

            $productsDataProvider = new \yii\data\ActiveDataProvider([
                'query'      => $productsQuery,
                'pagination' => false,
            ]);
        }

        return $this->render('index', [
            'model'                => $model,
            'productsDataProvider' => $productsDataProvider,
        ]);

        throw new \yii\web\NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionCarCareProducts()
    {
        $productsQuery = Product::find()
            ->where(['status' => '1'])
            ->andWhere(['>', 'price', '0'])
            ->andWhere(['IN', 'id_category', [18]])
            //->andWhere(['IS NOT', 'id_image', new Expression('null')])
            ->orderBy([
                'id_image' => SORT_DESC,
                'name'     => SORT_ASC,
                'price'    => SORT_DESC,
            ]);

        $productsDataProvider = new \yii\data\ActiveDataProvider([
            'query'      => $productsQuery,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        return $this->render('car_care', [
            'productsDataProvider' => $productsDataProvider,
        ]);
    }

    public function actionUsedParts()
    {
        $productsQuery = Product::find()
            ->where(['status' => '1'])
            ->andWhere(['is_new' => '0'])
            ->andWhere(['>', 'price', '0'])
            ->orderBy([
                'id_image' => SORT_DESC,
                'name'     => SORT_ASC,
                'price'    => SORT_DESC,
            ]);
            

        $productsDataProvider = new \yii\data\ActiveDataProvider([
            'query'      => $productsQuery,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('used_parts', [
            'productsDataProvider' => $productsDataProvider,
        ]);
    }
}
