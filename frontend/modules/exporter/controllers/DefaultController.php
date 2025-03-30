<?php

namespace frontend\modules\exporter\controllers;

use common\models\ProductQuantity;
use Shuchkin\SimpleXLSXGen;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Product;
use common\models\Category;
use common\models\Settings;

/**
 * Default controller for the `exporter` module
 */
class DefaultController extends Controller {

    private $delimiter = ',';
    private $minprice  = 0;
    private $prom_export  = 1;
    private $host      = '';
    private $filename  = 'export.csv';
    private $qty       = 10;

    public function __construct($id, $module, $config = [])
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        $this->host = \Yii::$app->request->hostInfo;

        parent::__construct($id, $module, $config);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(Url::home());
    }

    private function getProducts()
    {
        return Product::find()
            ->where(['status' => '1'])
            //->andWhere(['>', 'id_category', '0'])
            //->andWhere(['>', 'id_brand', '0'])
            ->andWhere(['IS NOT', 'id_image', new Expression('NULL')])
            ->andWhere(['prom_export' => $this->prom_export])
            ->andWhere(['>', 'price', $this->minprice])
            ->andWhere(['>', 'count', 0])
            ->orderBy(['id' => SORT_ASC])
            //->limit(55)
            ->all();
    }

    // /exporter/google?
    public function actionGoogle() {
        $this->delimiter = "\t";
        $this->prom_export = null; // all products
        $this->filename = 'google_'.time().'.txt';
        $tmp_filename   = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp             = fopen($tmp_filename, 'w');
        // id	title	description	link	price	availability	image_link	gtin	mpn	brand
        $cur_line       = [
            'id', // Унікальний_ідентифікатор
            'title',
            'description',
            'link',
            'price',
            'availability',
            'image_link',
            'gtin', // Код GTIN международный код маркировки и учета логистических единиц
            'mpn', // Код производителя товара [mpn]
            'brand',
        ];
        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {

            $description = strip_tags($product->description);
            $description .= $product->analog . ' ' . $product->applicable;
            $description = trim(preg_replace('/\s+/', ' ', $description)); // Remove new lines from string
            $description = \yii\helpers\StringHelper::truncateWords(strip_tags($description), 30, '');

            $link    = $this->host . Url::to(['/product/index', 'id' => $product->id, 'url' => $product->url]);
            $imgLink = $product->id_image ? $this->host . $product->image->getOriginalLink() : '';

            $product->name = preg_replace('!\s+!', ' ', $product->name); // Remove new lines from string

            $keywords = $product->name . ' ' . $product->brand->name . ' ' . $product->upc . ' ' . $product->analog;
            $keywords = preg_replace('!\s+!', ' ', $keywords); // Remove new lines from string

            $cur_line = [
                $product->id,
                $product->name,
                $description,
                $link,
                $product->finalPrice . ' UAH',
                'in_stock',
                $imgLink,
                '', // gtin
                $product->upc, // mpn
                $product->brand ? $product->brand->name : 'americancars', // Виробник
            ];
            fputcsv($fp, $cur_line, $this->delimiter);
        }
        fclose($fp);

        return Yii::$app->response->sendFile($tmp_filename, $this->filename);
    }

    // /exporter/prom?
    public function actionProm() {
        
        $this->filename = 'promua_'.time().'.csv';
        $tmp_filename   = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp             = fopen($tmp_filename, 'w');
        $cur_line       = [
            'Ідентифікатор_товару', // Унікальний_ідентифікатор
            'Код_товару', 
            'Назва_позиції', 
            'Назва_позиції_укр', 
            'Пошукові_запити', 
            'Пошукові_запити_укр', 
            'Опис', 
            'Опис_укр', 
            'Тип_товару', 
            'Ціна',
            'Оптова_ціна',
            'Мінімальне_замовлення_опт',
            'Валюта',
            'Одиниця_виміру',
            'Наявність',
            'Виробник',
            'Номер_групи',
            'Назва_групи',
            'Продукт_на_сайті',
            'Посилання_зображення',
            ];
        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {

            $description = strip_tags($product->description);
            $description .= $product->analog . ' ' . $product->applicable;
            $description = trim(preg_replace('/\s+/', ' ', $description)); // Remove new lines from string
            $description = \yii\helpers\StringHelper::truncateWords(strip_tags($description), 30, '');

            $link    = $this->host . Url::to(['/product/index', 'id' => $product->id, 'url' => $product->url]);
            $imgLink = $product->id_image ? $this->host . $product->image->getOriginalLink() : '';

            $product->name = preg_replace('!\s+!', ' ', $product->name); // Remove new lines from string
            //$product->name = str_ireplace($product->brand->name, '', $product->name);
            //$product->name = $product->brand->name . ' ' . $product->name;

            $keywords = $product->name . ' ' . $product->brand->name . ' ' . $product->upc . ' ' . $product->analog;
            $keywords = preg_replace('!\s+!', ' ', $keywords); // Remove new lines from string

            $cur_line = [
                $product->id,
                $product->upc,
                $product->name,
                $product->name,
                $keywords, //'Пошукові_запити',
                $keywords, //'Пошукові_запити_укр',
                $description, //'Опис',
                $description, //'Опис_укр',
                'u', // r ― в роздріб; w ― оптом; u ― оптом і в роздріб; s ― послуга
                $product->finalPrice, //'Ціна',
                $product->finalPrice, //'Оптова_ціна',
                5, //'Мінімальне_замовлення_опт',
                'UAH', // UAH | USD | EUR | CHF |  GBP | JPY | PLZ | інша | BYN | KZT | MDL | р | руб | дол | $ | грн
                'шт.', // шт. | упаковка | комплект | пара | м | пог.м | кг | набір | рулон | пач | моток | кв.м | од. | 100 г | л | бобіна | лист | г
                '+', // Наявність "+" — є в наявності "-" — немає в наявності "&" — очікується "@" — послуга
                $product->brand ? $product->brand->name : '', // Виробник
                $product->id_category, // 'Номер_групи',
                $product->category ? $product->category->name : '', // 'Назва_групи',
                $link, // 'Продукт_на_сайті',
                $imgLink, // 'Посилання_зображення',
            ];
            fputcsv($fp, $cur_line, $this->delimiter);
        }
        fclose($fp);

        return Yii::$app->response->sendFile($tmp_filename, $this->filename);

//        $response = Yii::$app->getResponse();
//        header('Content-type: text/csv');
//        header('Content-disposition: attachment;filename=' . $this->filename);
//        $response->clearOutputBuffers();
//        flush();
//        return readfile($tmp_filename);
    }

    // vseceni
    public function actionVseceni() {
        $this->filename  = 'vseceni.csv';
        $this->delimiter = ';';

        $tmp_filename = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp           = fopen($tmp_filename, 'w');
        $cur_line     = ['Категория товара', 'Производитель', 'Наименование товара', 'Код модели (артикул производителя)', 'Описание товара', 'Цена розн., грн.', 'Гарантия', 'Наличие', 'Ссылка на товар', 'Ссылка на изображение'];

        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {
            if (is_object($product->category) && is_object($product->brand)) {
                $descr = empty($product->descr_short) ? strip_tags($product->description) : strip_tags($product->descr_short);
                $descr = trim(preg_replace('/\s+/', ' ', $descr)); //Remove new lines from string
                $descr = \yii\helpers\StringHelper::truncateWords(strip_tags($descr), 30, '');

                $link = $this->host . Url::to(['/product/index', 'url' => $product->url, 'id' => $product->id]);

                $img_lnk = $product->id_image1 ? $this->host . $product->image1->getOriginalLink() : '';

                $product->name = preg_replace('!\s+!', ' ', $product->name); //Remove new lines from string
                $product->name = str_ireplace($product->brand->name, '', $product->name);
                $product->name = $product->brand->name . ' ' . $product->name;

                $cur_line = [
                    @$product->category->name,
                    @$product->brand->name,
                    $product->name,
                    $product->upc,
                    $descr,
                    $product->finalPrice,
                    $product->warranty,
                    $this->qty,
                    $link,
                    $img_lnk
                ];

                fputcsv($fp, $cur_line, $this->delimiter);
            }
        }
        fclose($fp);

        $response = Yii::$app->getResponse();
        //$headers = $response->getHeaders();
        //$headers->set('Content-Type', 'text/csv');
        //$headers->set('Content-disposition', 'attachment;filename=' . $this->filename);

        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $this->filename);
        //ob_clean();
        $response->clearOutputBuffers();
        flush();
        readfile($tmp_filename);
        return;
    }

    public function actionHotline() {

        $this->minprice = (int)Settings::getValue('min_price_hotline') ?: 1000;
        $this->filename = 'hotline.csv';
        $tmp_filename   = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp             = fopen($tmp_filename, 'w');
        $cur_line       = ['Категория товара', 'Производитель', 'Наименование товара', 'Код модели (артикул производителя)', 'Описание товара', 'Цена розн., грн.', 'Гарантия', 'Наличие', 'Ссылка на товар', 'Ссылка на изображение'];
        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {
            if (is_object($product->category) && is_object($product->brand)) {
                $descr = empty($product->descr_short) ? strip_tags($product->description) : strip_tags($product->descr_short);
                $descr = trim(preg_replace('/\s+/', ' ', $descr)); //Remove new lines from string
                $descr = \yii\helpers\StringHelper::truncateWords(strip_tags($descr), 30, '');

                $link = $this->host . Url::to(['/product/index', 'url' => $product->url, 'id' => $product->id]);

                $img_lnk = $product->id_image1 ? $this->host . $product->image1->getOriginalLink() : '';

                $product->name = preg_replace('!\s+!', ' ', $product->name); //Remove new lines from string
                $product->name = str_ireplace($product->brand->name, '', $product->name);
                $product->name = $product->brand->name . ' ' . $product->name;

                $cur_line = [
                    @$product->category->name,
                    @$product->brand->name,
                    $product->name,
                    $product->upc,
                    $descr,
                    $product->finalPrice,
                    $product->warranty .' месяцев, от производителя',
                    $this->qty,
                    $link,
                    $img_lnk
                ];

                fputcsv($fp, $cur_line, $this->delimiter);
            }
        }
        fclose($fp);

        $response = Yii::$app->getResponse();
        //$headers = $response->getHeaders();
        //$headers->set('Content-Type', 'text/csv');
        //$headers->set('Content-disposition', 'attachment;filename=' . $this->filename);

        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $this->filename);
        //ob_clean();
        $response->clearOutputBuffers();
        flush();
        readfile($tmp_filename);
        return;
    }

    /**
     * This action generate CSV file
     * id;upc;title;category;brand
     * for hotline Parser
     */
    public function actionParser() {

        $this->delimiter = ';';
        $this->filename  = 'prod.csv';
        $tmp_filename    = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp              = fopen($tmp_filename, 'w');
        $cur_line        = ['id', 'upc', 'title', 'category', 'brand'];
        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {
            if (is_object($product->category) && is_object($product->brand)) {

                $product->name = preg_replace('!\s+!', ' ', $product->name); //Remove new lines from string
                //$product->name = str_ireplace($product->brand->name, '', $product->name);
                //$product->name = $product->brand->name . ' ' . $product->name;

                $cur_line = [
                    $product->id,
                    $product->upc,
                    $product->name,
                    @$product->category->name,
                    @$product->brand->name,
                ];

                fputcsv($fp, $cur_line, $this->delimiter);
            }
        }
        fclose($fp);

        $response = Yii::$app->getResponse();
        //$headers = $response->getHeaders();
        //$headers->set('Content-Type', 'text/csv');
        //$headers->set('Content-disposition', 'attachment;filename=' . $this->filename);

        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $this->filename);
        //ob_clean();
        $response->clearOutputBuffers();
        flush();
        readfile($tmp_filename);
        return;
    }

    /**
     * This action generate XML file
     * for Yandex.Market
     */
    public function actionYml() {
        $response = Yii::$app->getResponse();
        header('Content-type: text/xml');
        $response->clearOutputBuffers();
        flush();

        echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="2010-04-01 17:00">
    <shop>
        <name>Интернет-магазин '.Yii::$app->params['storeUrl'].'</name>
        <company>'.Yii::$app->params['storeName'].'</company>
        <url>https://'.Yii::$app->params['storeUrl'].'/</url>

        <currencies>
            <currency id="UAH" rate="1" plus="0"/>
        </currencies>

        <categories>' . "\n";




        echo '        </offers>' . "\n";
        echo '    </shop>' . "\n";
        echo '</yml_catalog>';
        return;
    }

    public function actionPriceua() {

        $this->minprice  = (int)Settings::getSetting('min_price_priceua')->value;
        $this->delimiter = ';';
        $this->filename  = 'priceua.csv';
        $tmp_filename    = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . $this->filename;
        $fp              = fopen($tmp_filename, 'w');
        $cur_line        = ['Тип товара', 'Производитель', 'Наименование  товара', 'Цена роз. $', 'Цена рзн грн', 'Цена бн грн', 'Гарантия', 'Наличие', 'Ссылка на товарную позицию', 'Ссылка на изображение'];
        fputcsv($fp, $cur_line, $this->delimiter);

        $products = $this->getProducts();
        foreach ($products as $product) {
            if (is_object($product->category) && is_object($product->brand)) {
                $descr = empty($product->descr_short) ? strip_tags($product->description) : strip_tags($product->descr_short);
                $descr = trim(preg_replace('/\s+/', ' ', $descr)); //Remove new lines from string
                $descr = \yii\helpers\StringHelper::truncateWords(strip_tags($descr), 30, '');

                $link = $this->host . Url::to(['/product/index', 'url' => $product->url, 'id' => $product->id]);

                $img_lnk = $product->id_image1 ? $this->host . $product->image1->getOriginalLink() : '';

                $product->name = preg_replace('!\s+!', ' ', $product->name); //Remove new lines from string
                $product->name = str_ireplace($product->brand->name, '', $product->name);
                $product->name = $product->brand->name . ' ' . $product->name;

                $cur_line = [
                    $product->category->name,
                    $product->brand->name,
                    $product->name,
                    round($product->finalPrice / 26), // Цена роз. $
                    $product->finalPrice, // Цена рзн грн
                    $product->finalPrice, // Цена бн грн
                    $product->warranty . ' месяцев, от производителя',
                    $this->qty,
                    $link,
                    $img_lnk
                ];

                fputcsv($fp, $cur_line, $this->delimiter);
            }
        }
        fclose($fp);

        $response = Yii::$app->getResponse();
        //$headers = $response->getHeaders();
        //$headers->set('Content-Type', 'text/csv');
        //$headers->set('Content-disposition', 'attachment;filename=' . $this->filename);

        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $this->filename);
        //ob_clean();
        $response->clearOutputBuffers();
        flush();
        readfile($tmp_filename);
        return;
    }

    private static function getCategoryChilds($id) {
        $model = Category::findOne($id);
        if ($model) {
            $return[] = $id;
            $childs   = $model->categories;
            foreach ($childs as $child) {
                $return[] = $child->id;
                array_merge($return, self::getCategoryChilds($child->id));
                //$return[] = self::getCategoryChilds($child->id);
            }
            return $return;
        }
        return [];
    }

    public function actionAgro() {

        $id_category = 4; // sadovaja-tehnika

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Store")
                ->setLastModifiedBy("Store")
                ->setTitle("Office 2007 XLSX for Store")
                ->setSubject("Office 2007 XLSX for Store")
                ->setDescription("Store " . date('d.m.Y'))
                //->setKeywords("office 2007 Store report")
                ->setCategory("Store inventory");
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Название прайс-листа')
                ->setCellValue('A2', 'Описание прайс-листа')
                ->setCellValue('A3', 'Наименование')
                ->setCellValue('B1', 'Интернет-магазин')
                ->setCellValue('B2', 'Прайс Store от ' . date('Y-m-d'))
                ->setCellValue('B3', 'Цена');
        // Rows to repeat at top
        //$objPHPExcel->getActiveSheet()->freezePane('A2');
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
        $objPHPExcel->getActiveSheet()->getStyle('A1:B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getFill()->getStartColor()->setRGB('94cd5a');
        $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFill()->getStartColor()->setRGB('bec0bf');

        $products = Product::find()->where(['id_category' => self::getCategoryChilds($id_category)])->andWhere(['>', 'price', 0])->orderBy(['id_brand' => SORT_ASC, 'title' => SORT_ASC])->all();
        $i        = 4;
        foreach ($products as $product) {

            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . $i)
                    ->getNumberFormat()
                    ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $product->name)
                    ->setCellValue('B' . $i, $product->finalPrice);
            $i++;
        }

        for ($letter = ord('A'); $letter <= ord('B'); $letter++)
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($letter))->setAutoSize(true);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sadova-tehnika-' . date('Y.m.d-H:i') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');
        exit;
    }

    public function actionNadavi() {
        $this->minprice = (int)Settings::getValue('nadavi_export_from_price') ?: 1000;

        if (!$xml_sitemap = Yii::$app->cache->get('nadavixml'.$this->minprice)) {  // проверяем есть ли закэшированная версия
            // Категории сайта
            $categories = Category::find()->where(['stat' => '1'])->orderBy(['id_parent' => SORT_ASC])->all();

            // Товары
            $products = $this->getProducts();

            $xml_sitemap = $this->renderPartial('nadavi-xml', [// записываем view на переменную для последующего кэширования
                'host' => $this->host,
                'categories' => $categories,
                'products' => $products,
            ]);;

            Yii::$app->cache->set('nadavixml'.$this->minprice, $xml_sitemap, 3600 * 1); // кэшируем результат
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');

        return $xml_sitemap;
    }

    public function actionHotliner() {
        $this->minprice = (int)Settings::getValue('min_price_hotline') ?: 1000;

        if (!$xml_sitemap = Yii::$app->cache->get('hotlinexml')) {  // проверяем есть ли закэшированная версия

            // Категории сайта
            $categories = Category::find()->where(['stat' => '1'])->orderBy(['id_parent' => SORT_ASC])->all();

            // Товары
            $products = $this->getProducts();

            $xml_sitemap = $this->renderPartial('hotline-xml', [// записываем view на переменную для последующего кэширования
                'host' => $this->host,
                'categories' => $categories,
                'products' => $products,
            ]);

            Yii::$app->cache->set('hotlinexml', $xml_sitemap, 60 * 10); // кэшируем результат
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml;charset=UTF-8');

        return $xml_sitemap;
    }

    /**
     * /exporter/usamotors
     *
     * @return void
     * @throws \yii\base\ErrorException
     */
    public function actionUsamotors()
    {
        $productQtys = ProductQuantity::find()
            ->where(['>', 'count', 0])
            ->andWhere(['>', 'price', 0])
            ->andWhere(['id_warehouse' => 35]) // Sofia
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();
        $data[] = [
            '<b>' . 'Код товару' . '</b>',
            '<b>' . 'Найменування повне' . '</b>',
            '<b>' . 'Бренд' . '</b>',
            '<b>' . 'Артикул' . '</b>',
            '<b>' . 'Кількість' . '</b>',
            '<b>' . 'Ціна' . '</b>',
            '<b>' . 'Аналоги' . '</b>',
            '<b>' . 'Застосування' . '</b>',
        ];

        foreach ($productQtys as $productQty) {
            if($product = $productQty->product) {
                $data[] = [
                    $product->num,
                    $product->name,
                    $product->brand->name ?? '',
                    $product->upc,
                    $productQty->count,
                    $productQty->priceUsd,
                    $product->analog,
                    $product->applicable,
                ];
            }
        }

        $xlsx = SimpleXLSXGen::fromArray($data);
        //$xlsx->mergeCells('A1:O1');
        $xlsx->autoFilter('C1:C1');
        $xlsx->freezePanes('A2');
        //$xlsx->saveAs('name.xlsx');
        $xlsx->setAuthor(Yii::$app->params['storeTitle'] . ' <' . Yii::$app->params['storeEmail'] . '>') // storeEmail
            ->setCompany(Yii::$app->params['storeTitle'] . ' <' . Yii::$app->params['storeEmail'] . '>')

            ->setTitle('Products ' . Yii::$app->params['storeUrl'])
            ->setSubject('Products')
            ->setKeywords('Products')
            ->setDescription('Products export')
            ->setCategory('Products, ' . Yii::$app->params['storeTitle'])
            ->setLanguage(Yii::$app->language)
            ->setApplication(Yii::$app->name);

        $xlsx->downloadAs('products-' . time() . '.xlsx');
        exit;

    }
    
    
}
