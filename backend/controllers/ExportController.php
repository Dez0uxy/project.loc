<?php

namespace backend\controllers;

use common\models\Brand;
use common\models\Currency;
use common\models\Product;
use common\models\ProductQuantity;
use common\models\Vendor;
use common\models\Warehouse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\web\Controller;

class ExportController extends Controller
{
    public function actionIndex()
    {

        if (Yii::$app->request->isPost) {
            $surcharge = Yii::$app->request->post('surcharge') / 100 + 1;
            $warehouseIds = Yii::$app->request->post('warehouse');
            $currency = Yii::$app->request->post('currency');

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle(Yii::t('app', 'Pricelist ' . date('d.m.Y')));
            $alignCenterStyle = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]];
            $alignRightStyle = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]];

            $row = 1;
            $sheet->setCellValueByColumnAndRow(1, $row, 'Назва');
            $sheet->setCellValueByColumnAndRow(2, $row, 'Бренд');
            $sheet->setCellValueByColumnAndRow(3, $row, 'Артикул');
            $sheet->setCellValueByColumnAndRow(4, $row, 'Ціна, ' . $currency);
            $sheet->setCellValueByColumnAndRow(5, $row, 'Кількість');
            $sheet->setCellValueByColumnAndRow(6, $row, 'Фото');

            $sheet->getStyle('A1:E1')->getFont()->setBold(true);
            $sheet->getStyle('A1:E1')->applyFromArray($alignCenterStyle);
            $spreadsheet->getActiveSheet()->freezePane('A2'); // Freeze Rows Above (A2)

            $brands = Brand::getArray();
            $exchangeRates = Currency::getRatesArray();

            $products = ProductQuantity::find()
                ->where(['>', 'count', 0])
                ->andWhere(['>', 'price', 0])
                ->andWhere(['IN', 'id_warehouse', $warehouseIds])
                ->all();
                //->createCommand()->getRawSql(); echo '<pre>'; var_dump($productsQuery); exit('</pre>');

            foreach ($products as $productQuantity) {
                if ($product = $productQuantity->product) {
                    if ($productQuantity->price > 0 && $productQuantity->count > 0) {
                        $row++;
                        $brand = array_key_exists($product->id_brand, $brands) ? $brands[$product->id_brand] : '';
                        $price = round($productQuantity->price * $surcharge, 2);
                        if ($currency === 'UAH') {
                            $rate  = $exchangeRates[$product['currency']];
                            $price = round($price * $rate, 2);
                        }
                        $sheet->setCellValueByColumnAndRow(1, $row, $product->name);
                        $sheet->setCellValueByColumnAndRow(2, $row, $brand);
                        $sheet->setCellValueByColumnAndRow(3, $row, $product->upc);
                        $sheet->setCellValueByColumnAndRow(4, $row, $price);
                        $sheet->setCellValueByColumnAndRow(5, $row, $productQuantity->count);
                        $sheet->setCellValueByColumnAndRow(6, $row, $product->id_image);
                    }
                }
            }

            $sheet->getStyle('E1:E' . $row)->applyFromArray($alignCenterStyle); // count col
            $sheet->getStyle('C2:C' . $row)->applyFromArray($alignRightStyle); // upc col

            $sheet->getStyle('A1:A1')->applyFromArray($alignCenterStyle); // only for selection

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="price_' . date('Y-m-d-H-i') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }

        return $this->render('index', [
            'warehouses' => Warehouse::getArray(),
        ]);
    }

}
