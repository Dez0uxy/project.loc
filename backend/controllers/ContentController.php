<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\News;

class ContentController extends Controller
{
    public function actionAddNews()
    {
        $model = new News();

        $news = News::find()->orderBy(['date' => SORT_DESC])->asArray()->all();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
 
            if ($model->imageFile && $model->imageFile->error === UPLOAD_ERR_OK) {
                $savePath = Yii::getAlias('@frontend/web/images/news/') . $model->imageFile->baseName . '.' . $model->imageFile->extension;

                if ($model->validate()) {
                    if ($model->imageFile->saveAs($savePath)) {
                        $model->image = 'images/news/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                        if ($model->save(false)) {
                            Yii::$app->session->setFlash('success', 'Новина успішно додана.');
                            return $this->redirect(['content/add-news']);
                        }
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при завантаженні файлу.');
            }
        }

        return $this->render('add-news', [
            'model' => $model,
            'news' => $news,
        ]);
    }

    public function actionDownloadImage($filename)
    {
        $filePath = Yii::getAlias('@frontend/web/images/news/') . $filename;

        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        }

        throw new \yii\web\NotFoundHttpException('Файл не знайдено.');
    }

    public function actionEditNews($id)
    {
        $model = News::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('error', 'Новину не знайдено.');
            return $this->redirect(['content/add-news']);
        }

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($imageFile && $imageFile->error === UPLOAD_ERR_OK) {
                $savePath = Yii::getAlias('@frontend/web/images/news/') . $imageFile->baseName . '.' . $imageFile->extension;

                if ($model->validate()) {
                    if ($imageFile->saveAs($savePath)) {
                        if (!empty($model->image) && file_exists(Yii::getAlias('@frontend/web/') . $model->image)) {
                            unlink(Yii::getAlias('@frontend/web/') . $model->image);
                        }

                        $model->image = 'images/news/' . $imageFile->baseName . '.' . $imageFile->extension;
                    }
                }
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Новина успішно оновлена.');
                return $this->redirect(['content/add-news']);
            } else {
                Yii::$app->session->setFlash('error', 'Не вдалося оновити новину.');
            }
        }

        return $this->render('edit-news', ['model' => $model]);
    }
    public function actionDeleteNews($id)
    {
        $news = News::findOne($id);

        if ($news) {
            $news->delete();
            Yii::$app->session->setFlash('success', 'Новина успішно видалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Новину не знайдено.');
        }

        return $this->redirect(['content/add-news']);
    }
}    