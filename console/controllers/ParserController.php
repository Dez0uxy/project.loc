<?php

namespace console\controllers;

use common\models\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use console\models\ParserProdStg;
use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;

class ParserController extends \yii\console\Controller
{
    private $debug = false;
    private $msg = false;
    private $url;
    private $groups = [
        //'/group/perednyaya-podveska/',
        //'/group/zadnjaja-podveska/' => 12,
        //'/group/filtry/' => 1,
        //'/group/amartizatory-podushki/' => 1,
        //'/group/stupitsy-podshipniki/' => 14,
        //'/group/emni-roliki/' => 1,
        //'/group/sistema-ohlazhdenija/' => 1,
        //'/group/sistema-zazhiganija/' => 21,
        //'/group/tormoznaja-sistema/' => 1,
        //'/group/rulevoe-upravlenie/' => 1,
        //'/group/sistema-gu-rulja/' => 1,
        //'/group/optika-lampochki/' => 1,
        //'/group/gayki-bolty-shpilki/' => 1,
        //'/group/differentsial/' => 1,
        //'/group/kpp-razdatka/' => 1,
        //'/group/elektrika/' => 1,
        //'/group/detali-dvigatelja/' => 1,
        //'/group/podushki-dvigatelja/' => 1,
        //'/group/shrusy-krestoviny/' => 1,
        //'/group/toplivnaja-sistema/' => 1,
        //'/group/stseplenie/' => 1,
        //'/group/konditsioner-otoplenie/' => 1,
        //'/group/sistema-ochistki-stekol/' => 1,
        //'/group/emblemy/' => 1,
        //'/group/starter-generator/' => 1,
        //'/group/detali-kuzova/' => 1,
        //'/group/avtohimija/' => 1,
        //'/group/rasprodazha/' => 1,
        //'/group/aksessuary/' => 1,
        //'/group/vyhlopnaja-sistema/' => 1,
    ];

    private $stgCats = [
        //'aksesuary'                              => 4,
        //'detali_dvyhuna'                         => 39,
        //'elementy_kriplennya'                    => 12,
        //'opalennya_ta_kondytsiyuvannya'          => 7,
        //'remeni_pryvodni_ta_hrm'                 => 27,
        //'vykhlopna_systema'                      => 1,
        //'detali_zcheplennya_korobky_ta_rozdatky' => 8,
        //'kuzov'                                  => 19,
        //'okholodzhennya'                         => 30,
        //'pidshypnyky_ta_matochyny'               => 19,
        //'inshe'                                  => 3,
        //'salnyky_ta_prokladky'                   => 60,
        //'palyvna_systema'                        => 7,
        //'ridyny'                                 => 7,
        //'napivosi_kardany_khrestovyny'           => 17,
        //'filtry'                                 => 40,
        //'elektroustatkuvannya'                   => 63, 
        //'halmivna_systema'                       => 72,
        'pidviska_ta_kermo'                      => 140,
    ];

    public function init()
    {
        ini_set('memory_limit', '1024M');
        date_default_timezone_set('Europe/Kiev');
        require(Yii::getAlias('@common/components/simple_html_dom.php'));
        parent::init();
    }

    // Команда "yii parser/atlas test" вызовет "actionAtlas()"
    public function actionAtlas()
    {
        $this->url = 'https://www.atlasparts.com.ua';
        $products_cnt = 0;
        //$path = Yii::getAlias('@console') . '/perednyaya-podveska.html';
        foreach ($this->groups as $g => $start) {
            $html = file_get_html($this->url . $g . '?p=' . $start);
            if (is_object($html)) {
                $lastPageUl = $html->find('ul.b-pagination li.pagination__item', -1);
                if (is_object($lastPageUl)) {
                    $lastPageA = $lastPageUl->find('a.pagination__item-btn', 0)->href;
                    $lastPage = (int)str_replace('?p=', '', $lastPageA);
                } else {
                    $lastPage = 1;
                }

                for ($i = $start; $i <= $lastPage; $i++) {
                    $html = file_get_html($this->url . $g . '?p=' . $i);
                    if (count($tableRows = $html->find('table.catalog__table tr.catalog__part')) > 0) {
                        foreach ($tableRows as $tableRow) {
                            $linkHref = $tableRow->find('a.catalog__part-info', 0)->href;
                            //$linkHref = str_replace(' / ', '/', $linkHref);
                            $link = $this->url . $linkHref;
                            if (strpos($link, '/.html') !== false) {
                                continue;
                            }
                            //echo $img_sm = $this->url . $tableRow->find('a.catalog__part-image img', 0)->src;
                            //echo "\n";
                            $title = $tableRow->find('a.catalog__part-info h6.catalog__part-info-title', 0)->plaintext;
                            $number = $tableRow->find('a.catalog__part-info span.catalog__part-info-number strong', 0)->plaintext;
                            $brand = $tableRow->find('a.catalog__part-info span.catalog__part-info-brand strong', 0)->plaintext;
                            $price = $tableRow->find('td.catalog__part-price span', 0)->plaintext;
                            $availability = $tableRow->find('td span.catalog__part-availability', 0)->plaintext;

                            // load prod page
                            $prodHtml = file_get_html($link);
                            //$prodHtml = file_get_html(Yii::getAlias('@console') . '/15735029.html');
                            if (is_object($prodHtml)) {
                                $div = $prodHtml->find('div.catalog_item__main', 0);
                                $img = $this->url . $div->find('div.catalog_item__photo div.catalog_item__photo-main a.mainpimage', 0)->href;
                                $group = $div->find('div.catalog_item__info-table table tr', 2)->find('td a', 0)->plaintext;
                                $alts = $prodHtml->find('div.row.catalog_item__desc div.col-md-6', 1)->find('p', 0)->plaintext;

                                $autos = $prodHtml->find('div#number div.modal-body ul.list-group');
                                $on_car = '';
                                foreach ($autos as $autoUl) {
                                    $autoBrand = $autoUl->find('li.list-group-item-success', 0)->plaintext;
                                    $autoModels = $autoUl->find('li.list-group-item');
                                    foreach (array_slice($autoModels, 1) as $autoLi) {
                                        $on_car .= trim($autoBrand) . ' ' . trim($autoLi->plaintext) . "\r\n";
                                    }
                                }
                            }

                            $check = ParserProd::find()->where(['brand' => $brand])->andWhere(['number' => $number])->one();
                            if (!$check) {
                                $array['ParserProd'] = ['link' => $link, 'group' => $group, 'title' => $title, 'number' => $number, 'brand' => $brand, 'price' => $price, 'availability' => $availability, 'img' => $img, 'alts' => $alts, 'on_car' => $on_car];
                                $model = new ParserProd();
                                $model->load($array);
                                if ($model->validate()) {
                                    $model->save();
                                    $products_cnt++;
                                } else {
                                    throw new \yii\base\ErrorException('group: ' . $g . ', page: ' . $i . "\n\n" . implode(PHP_EOL, $model->getFirstErrors()));
                                }
                            }
                        }
                    }
                    // ожидание n секунд
                    sleep(2);
                } // end for pagination
            }
        } // end foreach groups

        $this->stdout("\n\ndone: $products_cnt products\n", Console::BOLD);
    }

    /**
     * php yii parser/stg
     * @return int
     * @throws \yii\base\ErrorException
     */
    public function actionStg()
    {
        $this->url = 'https://stg.com.ua/';
        $products_cnt = 0;

        $this->debug = false;
        $sleep = 7;
        $page = Settings::getValue('parser_last_page') ?: 1;

        //cats
        foreach ($this->stgCats as $cat => $lastPage) {
            // pages
            for ($i = (int)$page; $i <= $lastPage; $i++) { // 511
                if ($this->debug) {
                    $html = file_get_html(Yii::getAlias('@app') . '/runtime/parts.html');
                } else {
                    // Create a stream
                    $opts      = [
                        'http' => [
                            'method' => 'GET',
                            'header' =>
                                "Accept-Language: ru,en-US;q=0.9,en;q=0.8,ru-RU;q=0.7\r\n" .
                                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
                                "Referer: " . $this->url . $cat . '?page=' . ($i - 1) . "\r\n" .
                                "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 11_0_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 OPR/72.0.3815.320\r\n" .
                                "Cookie: PHPSESSID=2a8uhfm61hdhoh779haovtpfl4; language=uk; currency=USD\r\n"
                        ]
                    ];
                    $myContext = stream_context_create($opts);

                    $html = file_get_html($this->url . $cat . '?page=' . $i, false, $myContext);
                }
                
                if (is_object($html)) {

                    $this->stdout("\r\nCategory $cat Page: " . $this->ansiFormat($i, Console::FG_YELLOW) . ' started at ' . date('H:i:s') . "   ", Console::ITALIC);
                    Settings::setValue('parser_last_page', $i);

                    if (count($tableRows = $html->find('table.parts tr')) > 0) {

                        $cnt = 0;
                        foreach ($tableRows as $tableRow) {

                            if ($cnt++) { // skip first header row

                                $linkHref = is_object($href = $tableRow->find('td a', 0)) ? $href->href : false;
                                $catalog  = $tableRow->find('td', 1)->plaintext;
                                $article  = $tableRow->find('td', 2)->plaintext;
                                $name     = $tableRow->find('td', 3)->plaintext;
                                $avail    = $tableRow->find('td', 4)->find('span span', 0)->plaintext;

                                //var_dump([$linkHref, $catalog, $article, $name, $avail]);exit;

                                $check = ParserProdStg::find()->where(['catalog' => $catalog])->andWhere(['article' => $article])->count();
                                if ($check) {
                                    continue;
                                }

                                // load prod page
                                if ($this->debug) {
                                    $prodHtml = file_get_html(Yii::getAlias('@app') . '/runtime/part.html');
                                } else {
                                    $prodHtml = file_get_html($linkHref, false, $myContext);
                                }
                                
                                if (is_object($prodHtml)) {

                                    $div              = $prodHtml->find('div.content div.align div.flex_col', 0);
                                    $h1               = $div->find('h1', 0)->plaintext;
                                    $product_comment  = $div->find('div.product_comment', 0)->plaintext;
                                    $cart_total       = $div->find('div.buy_block div.price_text div#cart-total', 0)->plaintext;
                                    $price            = str_replace(' грн', '', $cart_total);
                                    $info_application = $div->find('div.info_application', 0)->plaintext;
                                    $info_application = trim($info_application);

                                    $vartikul = $div->find('span#span_artikul', 0)->plaintext;
                                    $vartikul = trim($vartikul);

                                    $analog_h2 = $div->find('div.tags h2', 0)->plaintext;
                                    $analog    = $div->find('div.tags', 0)->plaintext;

                                    $analog = str_replace($analog_h2, '', $analog); // cut h2 from analog div
                                    $analog = str_replace('Артикул ' . $vartikul . ', является актуальной заменой каталожных номеров известных брендов американских запчастей:', '', $analog);
                                    $analog = trim($analog);

                                    $info_ra = [];

                                    //var_dump([$vartikul, $h1, $product_comment, $cart_total, $price]);exit;

                                    if ($vartikul) {
                                        $info_raHtml = file_get_html('https://stg.com.ua/carcatalog/getinfora.php?q1=' . $vartikul);
                                        $info_raRows = $info_raHtml->find('table.info_ra tr');

                                        if (count($info_raRows) > 0) {

                                            foreach ($info_raRows as $info_raRow) {
                                                $info_ra[] = [
                                                    'make'   => $info_raRow->find('td', 0)->plaintext,
                                                    'year'   => $info_raRow->find('td', 1)->plaintext,
                                                    'model'  => $info_raRow->find('td', 2)->plaintext,
                                                    'engine' => $info_raRow->find('td', 3)->plaintext,
                                                ];
                                            }
                                        }
                                    }

                                    $info_ra_text = implode("\r\n", array_map(function ($entry) {
                                        return implode(' ; ', $entry);
                                    }, $info_ra));

                                    $info_ra_text = substr($info_ra_text, 0, 65500);


                                    $title = trim($h1 . ' ' . $product_comment);

                                    $name = html_entity_decode($name);
                                    $name = trim($name);

                                    $array['ParserProdStg'] = [
                                        'link'    => $linkHref,
                                        'catalog' => $catalog,
                                        'article' => $article,
                                        'name'    => $name,
                                        'avail'   => $avail,
                                        'title'   => $title,
                                        'price'   => $price,
                                        'descr'   => $info_application,
                                        'cars'    => $info_ra_text,
                                        'analog'  => $analog,
                                    ];
                                    $model                  = new ParserProdStg();
                                    $model->load($array);
                                    if ($model->validate()) {
                                        $model->save();
                                        $products_cnt++;
                                    } else {
                                        throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                                    }
                                    // ожидание n секунд
                                    sleep($sleep);
                                }
                            }
                        }
                    }
                    // ожидание n секунд
                    sleep($sleep);
                    $this->stdout("\r\nPage: " . $i . ' prod count '.$products_cnt.' finished at ' . date('H:i:s') . "\r\n", Console::BOLD);
                }
            }
            Settings::setValue('parser_last_page', 1); // next category from 1st page
            //exit('cat done');
        }
        
        $name = $this->ansiFormat('Products: ' . $products_cnt, Console::FG_YELLOW);
        echo "\r\nFinished: $name \r\n\r\n";

        return ExitCode::OK;
    }

    public function actionDl()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $namesRow = 1;
        //names for columns
        $colNum = 1;
        $sheet->setCellValueByColumnAndRow($colNum, $namesRow, 'Ссылка');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Каталог');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Артикул');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Название');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Наличие');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Наименование');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Цена');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Описание');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Применимость');
        $sheet->setCellValueByColumnAndRow(++$colNum, $namesRow, 'Аналоги');

        $sheet->getStyle('A1:AJ' . $namesRow)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->freezePane('A3'); // Freeze Rows Above (A3)

        $row = $namesRow + 2;

        $models = ParserProdStg::find()
            //->where(['id_position' => 109])
            ->orderBy(['id' => SORT_ASC])
            //->limit(500)
            ->all();

        /* @var $model ParserProdStg */
        foreach ($models as $model) {
            $colNum = 1;
            $sheet->setCellValueByColumnAndRow($colNum, $row, $model->link);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->catalog);
            $sheet->getColumnDimensionByColumn($colNum)->setAutoSize(true);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->article);
            $sheet->getColumnDimensionByColumn($colNum)->setAutoSize(true);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->name);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->avail);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->title);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->price);
            $sheet->getColumnDimensionByColumn($colNum)->setAutoSize(true);
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->descr);
            $sheet->getColumnDimensionByColumn($colNum)->setWidth('85');
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->cars);
            $sheet->getColumnDimensionByColumn($colNum)->setWidth('85');
            $sheet->setCellValueByColumnAndRow(++$colNum, $row, $model->analog);
            $sheet->getColumnDimensionByColumn($colNum)->setWidth('85');

            $row++;
        }

//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="' . 'STG_' . time() . '.xlsx"');
//        header('Cache-Control: max-age=0');
//        header('Cache-Control: max-age=1');
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0
        $writer = new Xlsx($spreadsheet);
//        $writer->save('php://output');
        $writer->save('/Users/Dez0uxy/Downloads/STG_' . time() . '.xlsx');
        exit;
    }
}
