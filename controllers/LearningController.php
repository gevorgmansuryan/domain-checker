<?php


namespace app\controllers;


use app\common\services\whois\Whois;
use app\models\Server;
use app\models\ServerSearch;
use app\models\WhoisSandbox;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LearningController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ServerSearch();

        return $this->render('index', [
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $server = Server::findOne(['id' => $id]);
        if (!$server) {
            throw new NotFoundHttpException();
        }

        $sandbox = new WhoisSandbox();

        if (!in_array($server->status, [Server::STATUS_NOT_LEARNED, Server::STATUS_LEARNED])) {
            $sandbox->payload = $server->server_response;
        }

        if ($sandbox->load(Yii::$app->request->post()) && $sandbox->validate()) {
            $sandboxResponse = Whois::instance()->check($sandbox->domain);

            $sandbox->available = $sandboxResponse->available;
            $sandbox->expires = $sandboxResponse->expires;
            $sandbox->payload = $sandboxResponse->payload;
        }


        if ($server->load(Yii::$app->request->post())) {
            $server->save();

            Yii::$app->session->addFlash('success', 'Successfully saved.');

            return $this->refresh();
        }

        return $this->render('update', [
            'sandbox' => $sandbox,
            'server' => $server,
        ]);
    }
}