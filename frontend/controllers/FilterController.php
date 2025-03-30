<?php

namespace frontend\controllers;

use common\models\FilterAuto;
use common\models\Product;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class FilterController extends CommonController
{
    public function actionIndex()
    {
        $make = Yii::$app->request->get('make', null);
        $carModel = Yii::$app->request->get('model', null);
        $year = Yii::$app->request->get('year', null);
        $engine = Yii::$app->request->get('engine', null);

        $filterModel = FilterAuto::find()
            ->select('id_product')
            ->andFilterWhere([
                'vendor' => $make,
                'model'  => $carModel,
            ])
            ->andFilterWhere(['like', 'year', $year])
            ->andFilterWhere(['like', 'engine', $engine])
            ->groupBy('id_product')
            //->createCommand()->getRawSql();
            ->asArray()
            ->all();
        $productIds = ArrayHelper::getColumn($filterModel, 'id_product');

        $productsQuery = Product::find()
            ->where(['status' => '1'])
            ->andWhere(['>', 'price', '0'])
            ->andWhere(['IN', 'id', $productIds]);
            //->andWhere(['IS NOT', 'id_image', new Expression('null')]);

        $productsDataProvider = new \yii\data\ActiveDataProvider([
            'query'      => $productsQuery,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('index', [
            'model'                => new FilterAuto([
                'vendor' => $make,
                'model'  => $carModel,
                'year'   => $year,
                'engine' => $engine,
            ]),
            'productsDataProvider' => $productsDataProvider,
        ]);
    }

    public function actionVendorModel()
    {
        $vendor = Yii::$app->request->get('vendor', false);
        $carModel = Yii::$app->request->get('model', false);
        $year = Yii::$app->request->get('year', false);

        $return = [];
        if ($vendor && $carModel && $year) {
            $array = FilterAuto::getEnginesArray($vendor, $carModel, $year);
            foreach ($array as $engine) {
                $return['engine'][] = ['value' => $engine, 'text' => $engine];
            }

        } elseif ($vendor && $carModel) {
            $array = FilterAuto::getYearsArray($vendor, $carModel);
            foreach ($array as $value) {
                $return['year'][] = ['value' => $value, 'text' => $value];
            }

        } elseif ($vendor) {
            $array = FilterAuto::getModelsArray($vendor);
            foreach ($array as $value) {
                $return[] = ['value' => $value, 'text' => $value];
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $return;
    }

}
