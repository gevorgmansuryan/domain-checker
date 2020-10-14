<?php

/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\ServerSearch $searchModel
 */

use app\models\Server;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Learning';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'tld',
        'whois',
        [
            'attribute' => 'status',
            'value' => function(Server $server) {
                return Server::LEARNING_STATUS_LABELS[$server->status];
            },
            'filter' => Server::LEARNING_STATUS_LABELS,
            'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('app', 'All')]
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update}',
        ],
    ],
]);