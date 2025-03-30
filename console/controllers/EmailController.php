<?php

namespace console\controllers;

use common\models\Brand;
use common\models\Customer;
use common\models\FilterAuto;
use common\models\Images;
use common\models\ProductQuantity;
use common\models\Products;
use common\models\User;
use common\models\Users;
use common\models\Warehouse;
use Yii;
use common\models\Product;
use yii\console\ExitCode;
use yii\db\Expression;
use yii\helpers\Console;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class EmailController extends \yii\console\Controller
{

    public function actionIndex()
    {
        echo Yii::getAlias('@files') . "\r\n";
    }

    public function getAttachments($emlObj, $inbox, $email_number)
    {
        $return = [];

        if ($emlObj->ifdparameters) {
            foreach ($emlObj->dparameters as $object) {
                if (strtolower($object->attribute) == 'filename') {
                    $return['is_attachment'] = true;
                    $return['filename'] = iconv_mime_decode($object->value);
                }
            }
        }

        if ($emlObj->ifparameters) {
            foreach ($emlObj->parameters as $object) {
                if (strtolower($object->attribute) == 'name') {
                    $return['is_attachment'] = true;
                    $return['name'] = iconv_mime_decode($object->value);
                }
            }
        }

        if ($return['is_attachment']) {
            $return['attachment'] = imap_fetchbody($inbox, $email_number, 1);

            if ($emlObj->encoding === 3) { // 3 = BASE64
                $return['attachment'] = base64_decode($return['attachment']);
            } elseif ($emlObj->encoding === 4) { // 4 = QUOTED-PRINTABLE
                $return['attachment'] = quoted_printable_decode($return['attachment']);
            }
        }

        return $return;
    }

    /**
     * Cron job: php yii email/usa-email
     * @return int
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUsaEmail()
    {
        $deleteEmails = true;
        $files_array = [];
        /* connect to imap */
        $hostname = Yii::$app->params['imapHost'];
        $username = Yii::$app->params['imapUsername'];
        $password = Yii::$app->params['imapPassword'];

        /* try to connect */
        $inbox = \imap_open($hostname, $username, $password) or exit('Cannot connect to: ' . imap_last_error());

        /* grab emails */
        $emails = \imap_search($inbox, 'FROM "info@usamotors.com.ua"');

        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* put the newest emails on top */
            //rsort($emails);

            $email_number = 1;
            if ($email_number) {
                //foreach ($emails as $email_number) {

                /* get information specific to this email */
                //$overview  = imap_fetch_overview($inbox, $email_number, 0);
                //$message   = imap_fetchbody($inbox, $email_number, 2);
                $structure = \imap_fetchstructure($inbox, $email_number);

                $attachments = [];

                if (!isset($structure->parts)) { // simple
                    $attachments[] = $this->getAttachments($structure, $inbox, $email_number); // pass 0 as part-number
                } elseif (isset($structure->parts) && ($partsCount = count($structure->parts))) {
                    for ($i = 0; $i < $partsCount; $i++) {

                        //$attachments[] = getAttachments($structure->parts[$i], $i+1);

                        $attachments[$i] = [
                            'is_attachment' => false,
                            'filename'      => '',
                            'name'          => '',
                            'attachment'    => '',
                        ];

                        if ($structure->parts[$i]->ifdparameters) {
                            foreach ($structure->parts[$i]->dparameters as $object) {
                                if (strtolower($object->attribute) == 'filename') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = iconv_mime_decode($object->value);
                                }
                            }
                        }

                        if ($structure->parts[$i]->ifparameters) {
                            foreach ($structure->parts[$i]->parameters as $object) {
                                if (strtolower($object->attribute) == 'name') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = iconv_mime_decode($object->value);
                                }
                            }
                        }

                        if ($attachments[$i]['is_attachment']) {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i + 1);
                            if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            } elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                    }
                }

                // mark email for deletion
                if ($deleteEmails) {
                    imap_delete($inbox, $email_number);
                }

                if (count($attachments) != 0) {
                    $i = 1;
                    foreach ($attachments as $at) {
                        if ($at['is_attachment'] === true) {
                            // save prices as xls
                            $ext = pathinfo($at['filename'], PATHINFO_EXTENSION);
                            $save_path = Yii::getAlias('@files') . '/file_email' . ($i > 1 ? $i : '') . '.' . $ext;

                            if(file_exists($save_path)) {
                                unlink($save_path);
                            }
                            file_put_contents($save_path, $at['attachment']);
                            $files_array[] = $save_path;
                        }
                    }
                }
            }
            // delete all messages marked for deletion
            if ($deleteEmails) {
                imap_expunge($inbox);
            }
        }
        /* close the connection */
        imap_close($inbox);

        foreach ($files_array as $file) {
            $this->actionUsa($file);
        }


        return ExitCode::OK;
    }

    /**
     * php yii email/usa /home/amercars/americancars.com.ua/crm/files/file_email.xls
     *
     * @param string|false $readFile
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\ErrorException
     */
    public function actionUsa($readFile = false)
    {
        $warehouse = Warehouse::findOne(30); // Склад U

//        if(!$readFile) {
//            $readFile = Yii::getAlias('@files') . '/file_email.xls';
//        }
        $add = $upd = 0;
        if (file_exists($readFile)) {
            $objPHPExcel = IOFactory::load($readFile);

            // set count = 0 for usamotors
            //Product::updateAll(['count' => 0], ['id_warehouse' => $warehouse->id]);
            ProductQuantity::updateAll(['count' => 0], ['id_warehouse' => $warehouse->id]);
            $warehouse->updateAttributes(['price_updated' => gmdate('Y-m-d H:i:s')]);

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

                    if (empty($B) || empty($C) || stripos($B, 'Наименование полное') !== false) {
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
                            throw new \yii\base\ErrorException('Error save Brand: ' . implode(PHP_EOL, $brand->getFirstErrors()) .
                                implode(PHP_EOL, $brand->attributes));
                        }
                    }

                    // find product
                    $model = Product::find()
                        ->andWhere(['id_brand' => $brand->id])
                        ->andWhere(['upc' => $D])
                        ->one();
                    if ($model) {
                        $upd++;
                    } else {
                        $model = new Product([
                            'id_vendor'    => 2, // usamotors
                            'id_category'  => 0,
                            'id_brand'     => $brand->id,
                            'id_warehouse' => $warehouse->id, // originally from
                            'name'         => $B,
                            'upc'          => $D,
                            'count'        => (int)$F,
                            'count_min'    => 1,
                            'price'        => (float)$G,
                            'analog'       => $H,
                            'applicable'   => $I,
                            'is_new'       => 1,
                            'currency'     => 'USD',
                            'status'       => Product::STATUS_ACTIVE,
                        ]);

                        if (!$model->save()) {
                            throw new \yii\base\ErrorException('Error save Product: ' . implode(PHP_EOL, $model->getFirstErrors()) .
                                implode(PHP_EOL, $model->attributes));
                        }
                        $add++;
                        //Yii::$app->db->getQueryBuilder()->batchInsert(Product::tableName(), $columns, $rows);
                    }
                    $productQuantity = $model->getQuantityWarehouse($warehouse->id);
                    $productQuantity->updateAttributes([
                        'count'      => (int)$F,
                        'price'      => (float)$G,
                        'updated_at' => gmdate('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
        echo "\n\n" . $add . ' products added, ' . $upd . ' products updated.' . "\n";
    }

}
