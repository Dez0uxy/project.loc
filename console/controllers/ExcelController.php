<?php

namespace console\controllers;

use common\models\Brand;
use common\models\Category;
use common\models\Customer;
use common\models\FilterAuto;
use common\models\Images;
use common\models\Products;
use common\models\User;
use common\models\Users;
use common\models\Warehouse;
use Yii;
use common\models\Product;
use yii\base\ErrorException;
use yii\db\Expression;
use yii\helpers\Console;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExcelController extends \yii\console\Controller
{

    public function actionIndex()
    {
        $models = Product::find()
            ->where(['id_warehouse' => 34])
            ->andWhere(['price' => 0])
            ->andWhere(['count' => 0])
            ->all();

        foreach ($models as $model) {
            echo '#' . $model->id . ' deleted' . "\n\n";
            $model->delete();
        }

        echo Yii::getAlias('@files') . "\r\n";
    }

    public function actionFilter()
    {
        $nf = 0;
        $models = FilterAuto::find()->all();
        foreach ($models as $model) {
            if($p = Products::findOne($model->id_product)){
                //echo $model->id_product . ' = ';
                $p_new = Product::find()
                    ->where(['upc' => $p->upc])
                    //->andWhere(['name' => $p->name])
                    //->andWhere(['id_warehouse' => 34])
                    ->one();
                if($p_new) {
                    //$model->updateAttributes(['id_product' => $p_new->id]);
                    echo $p_new->upc . ': ' . $p_new->id ."\n\n";
                } else {
                    echo $model->id_product . ' = ';
                    echo "not found \n\n";
                    $nf++;
                    //$model->delete();
                }
            }
        }
        echo "\n\n not found: " .$nf . " items \n\n";
    }

    public function actionUsers()
    {
        $cnt = 0;
        $models = Users::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();
        foreach ($models as $model) {
            $transaction = \Yii::$app->db->beginTransaction();

            $user = new User();
            $user->username = $model->email;
            $user->email = $model->email;
            $user->status = User::STATUS_ACTIVE;
            $user->created_at = strtotime($model->ts);
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            if ($user->save()) {
                $customer = new Customer();
                $customer->id = $user->id;
                $customer->discount = $model->discount;
                $customer->email = $model->email;
                $customer->lastname = $model->lastname;
                $customer->firstname = $model->firstname;
                $customer->middlename = $model->middlename;
                $customer->tel = $model->tel;
                $customer->tel2 = $model->tel2;

                $customer->company = $model->company;
                $customer->address = $model->address;
                $customer->city = $model->city;
                $customer->automark = $model->automark;
                $customer->automodel = $model->automodel;
                $customer->city = $model->city;

                if ($customer->save()) {
                    $cnt++;
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    throw new \yii\base\ErrorException(implode(PHP_EOL, $customer->getFirstErrors()));
                }
            } else {
                $transaction->rollBack();
                throw new \yii\base\ErrorException(implode(PHP_EOL, $user->getFirstErrors()));
            }
        }

        echo $cnt . ' added.' . "\r\n";
    }

    public function actionImg($limit = -1)
    {
        $origPath = Yii::getAlias('@frontend/web/images/products/1c_ExportImageWWW/');

        $models = Product::find()
            ->where(['IS NOT', 'image_path', new Expression('null')])
            ->andWhere(['IS', 'id_image', new Expression('null')])
            ->limit($limit)
            ->all();

        $c = 0;
        foreach ($models as $model) {
            //find file
            $origFile = false;
            if (file_exists($origPath . $model->image_path)) {
                $origFile = $origPath . $model->image_path;
            } elseif (file_exists('/home/amercars/americancars.com.ua/www/images/products/' . $model->image_path)) {
                $origFile = '/home/amercars/americancars.com.ua/www/images/products/' . $model->image_path;
            } elseif (file_exists('/home/amercars/americancars.com.ua/www/images/products/ware30/' . $model->image_path)) {
                $origFile = '/home/amercars/americancars.com.ua/www/images/products/ware30/' . $model->image_path;
            }

            if ($origFile) {
                $imgData = getimagesize($origFile);
                $ext = pathinfo($model->image_path, PATHINFO_EXTENSION);
                if ($imgData) {
                    $image = new Images();
                    $image->width = $imgData[0];
                    $image->height = $imgData[1];
                    $image->ext = $ext;

                    if ($image->save() && $image->upload($origFile)) {
                        $model->updateAttributes(['id_image' => $image->id]);
                        $c++;
                        chmod($origFile, octdec('0666'));
                        @unlink($origFile);
                    }
                }
            } else {
                echo "\n\n File not found: #" . $model->id . ' ' . $model->image_path;
            }
        }
        $updated = $this->ansiFormat($c, Console::FG_YELLOW);
        echo "\nFinished, Updated: $updated\n";
    }

    /**
     * php yii excel/recount
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionRecount()
    {
        $warehouse = Warehouse::findOne(34); // Склад Основной

        $readFile = Yii::getAlias('@files') . '/recount.xls';

        $objPHPExcel = IOFactory::load($readFile);

        Product::updateAll(['count' => 0, 'price' => 0], ['id_warehouse' => $warehouse->id]);

        $count = $updated = 0;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

            foreach ($worksheet->getRowIterator() as $row) {
                $A = $B = $C = $D = $E = $F = $G = $H = $I = $J = $K = $L = $M = $N = '';
                foreach (range('A', 'N') as $letter) {
                    $$letter = '';
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    if (!is_null($cell)) {
                        //$coordinate = PHPExcel_Cell::coordinateFromString($cell->getCoordinate());
                        $coordinate = Coordinate::coordinateFromString($cell->getCoordinate());
                        foreach (range('A', 'N') as $letter) {
                            if ($coordinate[0] == $letter) {
                                $val = $cell->getCalculatedValue();
                                $$letter = $val ? trim($val) : null;
                            }
                        }
                    }
                }

                if (empty($B) || stripos($B, 'Номенклатура, Упаковка') !== false) {
                    continue;
                }

//                $arr = [];
//                foreach (range('A', 'N') as $letter) {
//                    $arr[$letter] = $$letter;
//                }
//                var_dump($arr);exit;


                $category = false;
                if($N) {
                    $category = Category::find()
                        ->where(['name' => $N])
                        ->one();
                    if (!$category) {
                        $category = new Category([
                            'name'   => $N,
                        ]);
                        if (!$category->save()) {
                            throw new \yii\base\ErrorException(implode(PHP_EOL, $category->getFirstErrors()));
                        }
                    }
                }

                // check Brand exist
                $brand = Brand::find()
                    ->where(['name' => $G])
                    ->one();
                if (!$brand) {
                    $brand = new Brand([
                        'name'   => $G,
                        'status' => Brand::STATUS_ACTIVE,
                    ]);
                    if (!$brand->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $brand->getFirstErrors()));
                    }
                }

                // check Product exist
                $model = Product::find()
                    ->where(['id_warehouse' => $warehouse->id])
                    ->andWhere(['id_brand' => $brand->id])
                    ->andWhere(['name' => $B])
                    ->andWhere(['upc' => $H])
                    ->one();

                if ($model) {
                    $model->updateAttributes([
                        'price'        => (float)$J,
                        'count'        => (int)$I,
                        //'availability' => $V,
                        //'image_path'   => str_replace('\\', '/', $F),
                    ]);
                    if($category) {
                        $model->updateAttributes(['id_category' => $category->id]);
                    }
                    $updated++;
                } else {
                    $model = new Product([
                        'id_vendor'    => 1,
                        'id_category'  => $category ? $category->id : 0,
                        'id_brand'     => $brand->id,
                        'id_warehouse' => $warehouse->id,
                        'name'         => $B,
                        'upc'          => $H,
                        //'availability' => $V,
                        'count'        => (int)$I,
                        'count_min'    => 1,
                        'price'        => (float)$J,
                        'analog'       => $C,
                        'applicable'   => $D,
                        'image_path'   => $F ? str_replace('\\', '/', $F) : null,
                        'is_new'       => 1,
                        'currency'     => 'USD',
                        'status'       => Product::STATUS_ACTIVE,
                    ]);

                    if (!$model->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                    }
                    $count++;
                }

                //Yii::$app->db->getQueryBuilder()->batchInsert(Product::tableName(), $columns, $rows);
            }
        }
        echo "\r\n" . $count . ' products added, ' . $updated . ' products updated.' . "\r\n";
    }

    public function actionOwn()
    {
        $readFile = Yii::getAlias('@files') . '/100522.xls';

        $objPHPExcel = IOFactory::load($readFile);

        $count = $updated = 0;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

            foreach ($worksheet->getRowIterator() as $row) {
                $A = $B = $C = $D = $E = $F = $G = $H = $I = $J = $K = $L = $M = $N = $O = $P = $Q = $R = $S = $T = $U = $V = $W = $X = '';
                foreach (range('A', 'X') as $letter) {
                    $$letter = '';
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    if (!is_null($cell)) {
                        //$coordinate = PHPExcel_Cell::coordinateFromString($cell->getCoordinate());
                        $coordinate = Coordinate::coordinateFromString($cell->getCoordinate());
                        foreach (range('A', 'X') as $letter) {
                            if ($coordinate[0] == $letter) {
                                $val = $cell->getCalculatedValue();
                                $$letter = $val ? trim($val) : null;
                            }
                        }
                    }
                }

                if (empty($A) || empty($S) || stripos($A, 'Номенклатура.Код') !== false || stripos($A, 'Прайс-лист на') !== false) {
                    continue;
                }

//                $arr = [];
//                foreach (range('A', 'X') as $letter) {
//                    $arr[$letter] = $$letter;
//                }
//                var_dump($arr);exit;

                $brand = Brand::find()
                    ->where(['name' => $P])
                    ->one();
                if (!$brand) {
                    $brand = new Brand([
                        'name'   => $P,
                        'status' => Brand::STATUS_ACTIVE,
                    ]);
                    if (!$brand->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $brand->getFirstErrors()));
                    }
                }

                // check Product exist
                $model = Product::find()
                    ->where(['name' => $F])
                    ->andWhere(['upc' => $O])
                    ->one();

                if ($model) {
                    $model->updateAttributes([
                        'price'        => (float)$T,
                        'count'        => (int)$U,
                        'availability' => $V,
                        'image_path'   => str_replace('\\', '/', $S),
                    ]);
                    $updated++;
                } else {
                    $model = new Product([
                        'id_vendor'    => 1,
                        'id_category'  => 0,
                        'id_brand'     => $brand->id,
                        'id_warehouse' => 34,
                        'name'         => $F,
                        'upc'          => $O,
                        'availability' => $V,
                        'count'        => (int)$U,
                        'count_min'    => 1,
                        'price'        => (float)$T,
                        'analog'       => $N,
                        'applicable'   => $Q,
                        'image_path'   => str_replace('\\', '/', $S),
                        'is_new'       => 1,
                        'currency'     => 'USD',
                        'status'       => Product::STATUS_ACTIVE,
                    ]);

                    if (!$model->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                    }
                    $count++;
                }


                //Yii::$app->db->getQueryBuilder()->batchInsert(Product::tableName(), $columns, $rows);
            }
        }
        echo "\r\n" . $count . ' products added, ' . $updated . ' products updated.' . "\r\n";
    }


    public function actionUsa()
    {
        $readFile = Yii::getAlias('@files') . '/email.xls';

        $objPHPExcel = IOFactory::load($readFile);

        $count = 0;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

            foreach ($worksheet->getRowIterator() as $row) {
                $A = $B = $C = $D = $E = $F = $G = $H = $I = $J = '';
                foreach (range('A', 'J') as $letter) {
                    $$letter = '';
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    if (!is_null($cell)) {
                        //$coordinate = PHPExcel_Cell::coordinateFromString($cell->getCoordinate());
                        $coordinate = Coordinate::coordinateFromString($cell->getCoordinate());
                        foreach (range('A', 'J') as $letter) {
                            if ($coordinate[0] == $letter) {
                                $val = $cell->getCalculatedValue();
                                $$letter = $val ? trim($val) : null;
                            }
                        }
                    }
                }

                if (empty($B) || stripos($B, 'Наименование полное') !== false) {
                    continue;
                }

                $brand = Brand::find()
                    ->where(['name' => $C])
                    ->one();
                if (!$brand) {
                    $brand = new Brand([
                        'name'   => $C,
                        'status' => Brand::STATUS_ACTIVE,
                    ]);
                    if (!$brand->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $brand->getFirstErrors()));
                    }
                }

                $model = new Product([
                    'id_vendor'    => 2,
                    'id_category'  => 0,
                    'id_brand'     => $brand->id,
                    'id_warehouse' => 30,
                    'name'         => $B,
                    'upc'          => $D,
                    'count'        => (int)$F,
                    'count_min'    => 1,
                    'price'        => (float)$H,
                    'analog'       => $I,
                    'applicable'   => $J,
                    'is_new'       => 1,
                    'currency'     => 'USD',
                    'status'       => Product::STATUS_ACTIVE,
                ]);

                if (!$model->save()) {
                    throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                }
                $count++;
                //Yii::$app->db->getQueryBuilder()->batchInsert(Product::tableName(), $columns, $rows);
            }
        }
        echo "\r\n" . $count . ' products added.' . "\r\n";
    }

    /**
     * * php yii excel/csv-sofia
     * @return void
     * @throws ErrorException
     */
    public function actionCsvSofia()
    {
        $updated = $created = 0;
        $warehouse = Warehouse::findOne(35); // sofia
        $readFile = Yii::getAlias('@files') . '/csv_sofia.csv';
        if (($handle = fopen($readFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $data = array_map('trim', $data);
                [$upc,$brandName,$name,$count,$price] = $data;

                if(!$upc || !$brandName || !$name || !$count || !$price) {
                    continue;
                }

                $brand = Brand::find()
                    ->where(['name' => $brandName])
                    ->one();
                if (!$brand) {
                    $brand = new Brand([
                        'name'   => $brandName,
                        'status' => Brand::STATUS_ACTIVE,
                    ]);
                    if (!$brand->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $brand->getFirstErrors()));
                    }
                }

                // check Product exist
                $model = Product::find()
                    ->where(['name' => $name])
                    ->andWhere(['upc' => $upc])
                    ->one();

                if ($model) {
                    $productQuantity = $model->getQuantityWarehouse($warehouse->id);
                    $productQuantity->updateAttributes([
                        'count'      => (int)$count,
                        'price'      => (float)$price,
                        'updated_at' => gmdate('Y-m-d H:i:s'),
                    ]);
                    $updated++;
                } else {
                    $model = new Product([
                        'id_category'  => 0,
                        'id_brand'     => $brand->id,
                        'id_warehouse' => $warehouse->id,
                        'name'         => $name,
                        'upc'          => $upc,
                        'currency'     => 'USD',
                    ]);
                    if (!$model->save()) {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                    }
                    $productQuantity = $model->getQuantityWarehouse($warehouse->id);
                    $productQuantity->updateAttributes([
                        'count'      => (int)$count,
                        'price'      => (float)$price,
                    ]);

                    $created++;
                }
            }
            fclose($handle);
        }
        exit("Created $created, updated $updated." . PHP_EOL);
    }
}
