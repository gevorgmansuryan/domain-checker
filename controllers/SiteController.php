<?php

namespace app\controllers;

use app\models\Domain;
use app\models\DomainFile;
use app\models\Server;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new DomainFile();
        if ($model->load(Yii::$app->request->post())) {
            $model->file_name = UploadedFile::getInstance($model, 'file_name');
            if ($model->validate() && $model->save()) {
                Yii::$app->session->addFlash('success', 'CSV successfully uploaded and will be processed soon.');

                return $this->refresh();
            }
        }

        $widgets = [
            Server::STATUS_SERVER_NOT_WORKING => Server::find()->where(['status' => Server::STATUS_SERVER_NOT_WORKING])->count(),
            Server::STATUS_CAN_NOT_PARSE_AVAILABLE => Server::find()->where(['status' => Server::STATUS_CAN_NOT_PARSE_AVAILABLE])->count(),
            Server::STATUS_CAN_NOT_PARSE_EXPIRED => Server::find()->where(['status' => Server::STATUS_CAN_NOT_PARSE_EXPIRED])->count(),
            Server::STATUS_EXPIRED_MAY_NOT_CORRECT => Server::find()->where(['status' => Server::STATUS_EXPIRED_MAY_NOT_CORRECT])->count(),
        ];

        return $this->render('index', [
            'model' => $model,
            'widgets' => $widgets,
        ]);
    }

    public function actionStats($file = null)
    {
        $files = ArrayHelper::index(DomainFile::find()->all(), 'id');

        if ($files && empty($files[$file])) {
            return $this->redirect(['stats', 'file' => array_key_first($files)]);
        }


        $file = ArrayHelper::getValue($files, $file);
        /** @var DomainFile $file */

        return $this->render('stats', [
            'files' => $files,
            'currentFile' => $file,
            'stats' => !$file ? null : [
                'progress' => $file->getDomains()->where(['status' => Domain::STATUS_PROCESSED])->count() / $file->getDomains()->count() * 100,
                'valid' => $file->getDomains()->where(['valid' => 1])->count(),
                'invalid' => $file->getDomains()->where(['valid' => 0])->count(),
                'dataProvider' => new ActiveDataProvider([
                    'query' => $file->getDomains()->where(['status' => Domain::STATUS_PROCESSED]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ])
            ]
        ]);
    }
}
