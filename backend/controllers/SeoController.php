<?php

namespace backend\controllers;

use common\models\Brand;
use common\models\Category;
use common\models\Product;
use common\models\User;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SeoController
 */
class SeoController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index', [
            'result' => '',
        ]);
    }
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionProduct()
    {

        ini_set('memory_limit', '256M');

        $counter = 0;
        $models = Product::find()
            ->where(['IS', 'meta_description', new Expression('NULL')])
            ->limit(2000)
            ->all();
        foreach ($models as $model) {
            if (!$model->setMetaTags()) {
                print_r($model->getErrors());
                exit;
            }
            $counter++;
        }
        return $this->render('index', [
            'result' => $counter . ' продуктов обновлено.',
        ]);
    }

    public function actionCategory()
    {

        ini_set('memory_limit', '256M');

        $counter = 0;
        $models = Category::find()->all();
        foreach ($models as $model) {
            if (!$model->setMetaTags()) {
                print_r($model->getErrors());
                exit;
            }
            $counter++;
        }
        return $this->render('index', [
            'result' => $counter . ' категорий обновлено',
        ]);
    }

    public function actionBrand()
    {

        ini_set('memory_limit', '256M');

        $counter = 0;
        $models = Brand::find()->all();
        foreach ($models as $model) {
            if (!$model->setMetaTags()) {
                print_r($model->getErrors());
                exit;
            }
            $counter++;
        }
        return $this->render('index', [
            'result' => $counter . ' брендов обновлено',
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
