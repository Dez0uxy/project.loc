<?php

namespace common\models;

use arogachev\sortable\behaviors\numerical\ContinuousNumericalSortableBehavior;
use Mpdf\Gif\Image;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $id_vendor
 * @property int $id_category
 * @property int $id_brand
 * @property int $id_warehouse
 * @property int|null $id_image
 * @property int|null $prom_export
 * @property string $name
 * @property string $url
 * @property string $upc
 * @property string $availability
 * @property int $count
 * @property int|null $count_min
 * @property int|null $count_max
 * @property float $price
 * @property string $weight
 * @property string $analog
 * @property string $applicable
 * @property string $image_path
 * @property int $is_new
 * @property int $extra_charge
 * @property string|null $currency
 * @property string $ware_place
 * @property string $note
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $status
 *
 * @property Warehouse $warehouse
 * @property Category $category
 * @property Brand $brand
 * @property Image $image
 * @property float $priceUah
 * @property float $priceUsd
 * @property float $finalPrice
 * @property float $cost
 * @property ProductQuantity[] $productQuantity
 * @property string $num
 */
class Product extends CommonModel implements CartPositionInterface
{
    use CartPositionTrait;

    public $costWarehouseId;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('app', 'активний'),
            self::STATUS_INACTIVE => Yii::t('app', 'неактивний'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                //'value' => new \yii\db\Expression('NOW()'),
                'value'      => static function () {
                    return gmdate('Y-m-d H:i:s');
                },
            ],
            'slug' => [
                'class'         => SluggableBehavior::className(),
                'attribute'     => 'name',
                'slugAttribute' => 'url',
                'immutable'     => true, // неизменный
                'ensureUnique'  => true, // генерировать уникальный
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vendor', 'id_category', 'id_brand', 'id_warehouse', 'id_image', 'prom_export', 'count', 'count_min', 'count_max', 'is_new', 'extra_charge', 'status', 'costWarehouseId'], 'integer'],
            [['price'], 'number'],
            [['analog', 'applicable', 'description'], 'string'],
            [['name', 'url', 'upc', 'availability', 'weight', 'ware_place', 'image_path'], 'string', 'max' => 255],
            [['note', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 512],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'Номер'),
            'id_vendor'        => Yii::t('app', 'Постачальник'),
            'id_category'      => Yii::t('app', 'Категорія'),
            'id_brand'         => Yii::t('app', 'Бренд'),
            'id_warehouse'     => Yii::t('app', 'Склад'),
            'id_image'         => Yii::t('app', 'Фото'),
            'prom_export'      => Yii::t('app', 'Експорт Пром'),
            'name'             => Yii::t('app', 'Назва'),
            'url'              => Yii::t('app', 'Url'),
            'upc'              => Yii::t('app', 'Артикул'),
            'availability'     => Yii::t('app', 'Наявність'),
            'count'            => Yii::t('app', 'Кількість'),
            'count_min'        => Yii::t('app', 'Min Кількість'),
            'count_max'        => Yii::t('app', 'Max Кількість'),
            'price'            => Yii::t('app', 'Ціна'),
            'weight'           => Yii::t('app', 'Вага'),
            'analog'           => Yii::t('app', 'Аналоги'),
            'applicable'       => Yii::t('app', 'Приміняємість'),
            'image_path'       => Yii::t('app', 'Фото'),
            'is_new'           => Yii::t('app', 'Новий'),
            'extra_charge'     => Yii::t('app', 'Націнка'),
            'currency'         => Yii::t('app', 'Валюта'),
            'ware_place'       => Yii::t('app', 'Місце на складі'),
            'note'             => Yii::t('app', 'Примітка'),
            'description'      => Yii::t('app', 'Опис'),
            'meta_title'       => Yii::t('app', 'Meta Title'),
            'meta_keywords'    => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'status'           => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNum()
    {
        return sprintf('%06d', $this->id);
    }

    /**
     * relational rules.
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_category']);
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'id_vendor']);
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'id_brand']);
    }

    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'id_image']);
    }

    public function getProductQuantity()
    {
        return $this->hasMany(ProductQuantity::className(), ['id_product' => 'id']);
    }

    public function getQuantityWarehouse($id_warehouse)
    {
        if ($warehouse = Warehouse::findOne($id_warehouse)) {
            if (!$model = ProductQuantity::find()
                ->where(['id_product' => $this->id])
                ->andWhere(['id_warehouse' => $warehouse->id])
                ->one()) {
                $model               = new ProductQuantity();
                $model->id_product   = $this->id;
                $model->id_warehouse = $warehouse->id;
                if (!$model->save()) {
                    throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                }
            }
            return $model;
        }
        throw new \yii\base\ErrorException('No warehouse found: ' . $id_warehouse);
    }

    public function getStatusName()
    {
        $statuses = self::getStatusArray();
        return array_key_exists($this->status, $statuses) ? $statuses[$this->status] : '-';
    }

    /**
     * Get price in UAH with currency conversion and add extra_charge from warehouse
     * @return float
     */
    public function getPriceUah()
    {
        if($this->costWarehouseId && ($productQuantity = $this->getQuantityWarehouse($this->costWarehouseId))) {
            return $productQuantity->priceUah;
        }
        $currency = $this->currency ?? 'USD'; // 'USD' або інша валюта за замовчуванням
        $price = $this->price * Currency::getValue($currency);
        // warehouse extra_charge
        if (($warehouse = $this->warehouse) && $warehouse->extra_charge > 0) {
            $price *= (1 + $warehouse->extra_charge / 100); // add extra_charge
        }
        // customer discount
        if (!Yii::$app->user->isGuest && ($customer = Yii::$app->user->identity->customer) && $customer->discount > 0) {
            $price *= (100 - $customer->discount) / 100;
        }
        return round($price, 0);
    }

    /**
     * Get price in USD add extra_charge from warehouse
     * @return float
     */
    public function getPriceUsd()
    {
        $price = $this->price;
        // warehouse extra_charge
        if (($warehouse = $this->warehouse) && $warehouse->extra_charge > 0) {
            $price *= (1 + $warehouse->extra_charge / 100); // add extra_charge
        }
        // customer discount
        if (!Yii::$app->user->isGuest && ($customer = Yii::$app->user->identity->customer) && $customer->discount > 0) {
            $price *= (100 - $customer->discount) / 100;
        }
        return round($price, 2);
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->finalPrice; // return price with discount for CartPositionTrait calculation, price without discount = getOldPrice()
    }

    /**
     * @inheritdoc
     */
    public function getFinalPrice()
    {
        $finalPrice = $this->priceUah;

        return round($finalPrice);
    }

    /**
     * @inheritdoc
     */
    public function getCost($withDiscount = true)
    {
        $finalPrice = $this->priceUah;

        return round($finalPrice);
    }

    private function uploadImg($img_input, $img_db)
    {
        if (isset($_FILES[$img_input]['tmp_name'])) {
            $tmpFileName = $_FILES[$img_input]['tmp_name'];
            $data        = $tmpFileName ? getimagesize($tmpFileName) : 0;
            $ext         = pathinfo($_FILES[$img_input]['name'], PATHINFO_EXTENSION);
            if ($data) {
                $image         = new Images();
                $image->width  = $data[0];
                $image->height = $data[1];
                $image->ext    = $ext;

                if ($image->save()) {
                    // delete old image
                    if ($this->{$img_db}) {
                        $img_model = \common\models\Images::findOne($this->{$img_db});
                        if ($img_model) {
                            $img_model->delete();
                        }
                    }
                    $image->upload($tmpFileName);
                    $this->{$img_db} = $image->id;
                }
            }
        }
    }

    private function mb_ucfirst($string) {
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }

    private function cutLastWord($string, $length = 65) {
        if(mb_strlen($string) > $length) {
            $words = preg_split('/(\s+)/u', trim($string), 0, PREG_SPLIT_DELIM_CAPTURE);
            $string = implode('', array_slice($words,0, -1));
            return $this->cutLastWord($string, $length);
        }
        return trim($string);
    }

    /**
     * Updates model meta using Settings
     *
     * @return boolean
     */
    public function setMetaTags()
    {
        $brand = $this->brand ? $this->brand->name . ' ' : '';
        $this->name = str_replace(', шт', '', $this->name);
        $name = $brand . $this->name . ' ' . $this->upc;

        $titleTempalte = '%var1% %name% за %var2% %var3%';
        $priceVars = ['ціною', 'вартістю'];
        $buyVars = ['купити', 'замовити', 'придбати'];
        $priceTypeVars = ['доступною', 'вигідною', 'привабливою', 'конкурентною', 'оптимальною', 'бюджетною', 'прийнятною', 'демократичною', 'розумною', 'помірною', 'справедливою'];
        $vendorVars = ['виробника', 'дилера', 'доступною кожному'];
        $find = ['%name%', '%var1%', '%var2%', '%var3%'];
        $replace = [
            $name,
            $this->mb_ucfirst($buyVars[array_rand($buyVars)]),
            $priceTypeVars[array_rand($priceTypeVars)],
            $priceVars[array_rand($priceVars)]
        ];
        $this->meta_title = str_replace($find, $replace, $titleTempalte);
        $this->meta_title = $this->cutLastWord($this->meta_title, 65);

        $speedVars = ['швидкою', 'експрес', 'оперативною', 'надійною', 'гарантованою', 'майже миттєвою'];
        $shipVars = ['по Україні', 'у будь-яке місто України', 'у будь-яку точку України', 'по всій території України', 'у кожне місто України', 'у будь-який куточок України', 'у кожен регіон України', 'в усі куточки України'];
        $endVars = [
            'Зробіть правильний вибір і замовте просто зараз',
            'Не пропустіть шанс і придбайте товар вже сьогодні',
            'Відправка сьогодні - зробіть замовлення',
            'Покваптеся і замовте просто зараз, поки є в наявності',
            'Не відкладайте на завтра те, що може бути вашим уже сьогодні',
            'Ваш час настав - замовте та змініть ваше авто на краще',
            'Не чекайте подарунків долі, зробіть собі подарунок уже сьогодні',
            'Час діяти - зроби замовлення просто зараз',
            'Ваш успіх на відстані одного кліка - замовте просто зараз',
            'Не чекайте кращого моменту - зробіть замовлення і створіть його самостійно',
            'Не пропустіть можливість і відправте замовлення просто зараз',
            'Відправлення товару вже сьогодні - зробіть свою найкращу покупку',
            'Не чекайте на кращі умови - замовляйте просто зараз',
            'Відкрийте нові можливості, зробивши замовлення вже сьогодні',
            'Купи і посмішку отримаєш у подарунок',
            'Досить сумніватися, купи і посміхнися',
            'Веселий товар, серйозно швидка доставка',
            'Радість у кожному замовленні',
            'Зроби свій вибір',
            'Купи зараз, посміхнися потім',
            'Насмілься на невелику ексцентричність - зроби замовлення сьогодні',
        ];

        // meta_description
        $descrTempalte = '%name% %var1% %var2% %var3% %var4%';
        if ($this->id % 2 == 0) { // Even
            $var2 = 'за ' . $priceTypeVars[array_rand($priceTypeVars)] . ' ' . $priceVars[array_rand($priceVars)];
        } else { // Odd
            $var2 = 'за ціною ' . $vendorVars[array_rand($vendorVars)];
        }
        $var3 = 'з ' . $speedVars[array_rand($speedVars)] . ' доставкою ' . $shipVars[array_rand($shipVars)];

        $find                   = ['%name%', '%var1%', '%var2%', '%var3%', '%var4%'];
        $replace                = [
            $name,
            $this->mb_ucfirst($buyVars[array_rand($buyVars)]),
            $var2,
            $var3,
            $endVars[array_rand($endVars)],
        ];
        $this->meta_description = str_replace($find, $replace, $descrTempalte);
        $this->meta_description = $this->cutLastWord($this->meta_description, 320);

        // meta_keywords
        $this->meta_keywords = $this->upc;
        if ($this->analog) {
            $this->meta_keywords .= ', ' . str_replace(['/', ';'], ',', $this->analog);
        }
        $this->meta_keywords = rtrim($this->meta_keywords, ', ');
        $arr = explode(',', $this->meta_keywords);
        $arr = array_map('trim', $arr);
        $arr = array_unique($arr);
        $this->meta_keywords = implode(',', $arr);
        $this->meta_keywords = StringHelper::truncate($this->meta_keywords, 500);
        //echo '<pre>';var_dump([$this->id, $this->meta_title, $this->meta_description, $this->meta_keywords]);exit('</pre>');

        return $this->save();
    }

    public static function replaceId($id, $id_remove)
    {
        if($remove = Product::findOne($id_remove)) {
            $remove->delete();
        }

        return [
            'FilterAuto'              => FilterAuto::deleteAll(['id_product' => $id_remove]),
            'IncomeProduct'           => IncomeProduct::deleteAll(['id_product' => $id_remove]),
            'ProductInventoryHistory' => ProductInventoryHistory::deleteAll(['id_product' => $id_remove]),
            'ProductQuantity'         => ProductQuantity::deleteAll(['id_product' => $id_remove]),
            'OrderProduct'            => OrderProduct::updateAll(['id_product' => $id], ['id_product' => $id_remove]),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            // upload multiple images: id_image1 id_image2 ...
            $this->uploadImg('image', 'id_image');

            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // delete FeatureProduct
            // Yii::$app->db->createCommand()->delete(FeatureProduct::tableName(), ['id_product' => $this->id])->execute();

            // delete image
            //for ($i = 1; $i < 2; $i++) {
            if ($this->{'id_image'}) {
                $imgModel = Images::findOne($this->{'id_image'});
                if ($imgModel) {
                    $imgModel->delete();
                }
            }
            //}

            return true;
        }
        return false;
    }
}
