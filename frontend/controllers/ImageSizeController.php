<?php

namespace frontend\controllers;

use common\models\Images;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\Controller;

class ImageSizeController extends Controller
{

    public function actionIndex($file)
    {
        if (preg_match('/([\d]{1})\/([\w]+)\/([\d]+).jpg/', $file, $matches)) {
            $this->actionParams($matches[3], $matches[2], $matches[1]);
        }
    }

    public function actionTest($id, $size = '320x320', $crop = 2)
    {
        $this->actionParams($id, $size, $crop);
    }

    /**
     * @param $image \common\models\Images
     * @param $width int
     * @param $height int
     * @param $crop int
     * @return \yii\console\Response|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    private function showImage($image, $width, $height, $crop)
    {
        //Yii::$app->response->setDownloadHeaders($filename);
        $file_path = Yii::getAlias('@frontend/web') . $image->getLink($width, $height, $crop);
        $response = \Yii::$app->response;
        $response->format = yii\web\Response::FORMAT_RAW;
        $mimeType = FileHelper::getMimeType($file_path);
        if ($mimeType !== null) {
            $response->headers->add('content-type', $mimeType);
        }
        $img_data = file_get_contents($file_path);
        $response->data = $img_data;
        return $response;
    }

    public function actionParams($id, $size = '', $crop = 1)
    {
        //exit('by');
        $crop = intval($crop);

        if (!empty($size)) {

            [$width, $height] = explode('x', $size);

            $width = intval($width);
            $height = intval($height);

            if ($image = Images::find()->where(['id' => $id])->one()) {

                $width = ($width < 1) ? $image->width : $width;
                $height = ($height < 1) ? $image->height : $height;

                $width = ($width > 2000) ? 2000 : $width;
                $height = ($height > 2000) ? 2000 : $height;

                // check if image exists
                if ($image->checkExistense($width . 'x' . $height, $crop)) {
                    //return $this->showImage($image, $width, $height, $crop);
                    //$this->redirect($image->getLink($width, $height, $crop, true));
                }

                $tmp = $image->downloadToTmpFile();

                $imagine = Image::getImagine();

                $size = new Box($width, $height);
                switch ($crop) {
                    case 4:
                        $mode = ImageInterface::THUMBNAIL_FLAG_NOCLONE;
                        break;
                    case 3:
                        $mode = ImageInterface::THUMBNAIL_FLAG_UPSCALE;
                        break;
                    case 2:
                        $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                        break;
                    case 1:
                    default:
                        $mode = ImageInterface::THUMBNAIL_INSET;
                        break;
                }
                
                $img = $imagine->open(Yii::getAlias($tmp));
                $exif = exif_read_data(Yii::getAlias($tmp));

                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $img->rotate(180);
                            break;
                        case 6:
                            $img->rotate(90);
                            break;
                        case 8:
                            $img->rotate(-90);
                            break;
                    }
                }

                if ($crop == 1) {
                    $min = min($image->width, $image->height);
                    $aspect = $width / $height;
                    if ($width > $height) {
                        $cropW = $min;
                        $cropH = $min / $aspect;
                    } elseif ($width < $height) {
                        $cropH = $min;
                        $cropW = $min * $aspect;
                    } else {
                        $cropH = $min;
                        $cropW = $min;
                    }
                    // crop original with aspect and resize
                    $img->crop(new Point(0, 0), new Box($cropW, $cropH))->thumbnail($size, $mode)->save(Yii::getAlias($tmp), ['quality' => 90]);
                } else {
                    $img->thumbnail($size, $mode)
                        ->save(Yii::getAlias($tmp), ['quality' => 90]);
                }

                $image->uploadResized($tmp, $width . 'x' . $height, $crop);
                unlink($tmp);

                //$this->redirect($image->getLink($width, $height, $crop, true));
                return $this->showImage($image, $width, $height, $crop);
            }
        }
    }

}
