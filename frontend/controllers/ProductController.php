<?php

namespace frontend\controllers;

use common\models\Product;
use Yii;

class ProductController extends CommonController
{
    public function actionIndex($id = null, $url = '')
    {
        $model = Product::findOne((int)$id);

        if ($model) {
            return $this->render('index', [
                'model'                => $model,
            ]);
        }
        throw new \yii\web\NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

}
