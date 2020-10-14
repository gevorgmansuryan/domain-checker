<?php

/**
 * @var $this yii\web\View
 * @var DomainFile[] $files
 * @var array $stats
 * @var DomainFile $currentFile
 */

use app\assets\ChartAsset;
use app\models\DomainFile;
use practically\chartjs\Chart;
use yii\bootstrap\Progress;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

ChartAsset::register($this);

$this->title = 'Stats';
$this->params['breadcrumbs'][] = $this->title;

$items = [];

foreach ($files as $file) {
    $items = [];
}

if (empty($files)) {
    echo Html::tag('h1', 'No CSV files uploaded yet.');
} else {
    echo Tabs::widget([
        'items' => ArrayHelper::getColumn($files, function(DomainFile $file) use ($currentFile) {
            return [
                'active' => $currentFile && $currentFile->id == $file->id,
                'label' => StringHelper::truncate($file->title, 10),
                'url' => ['stats', 'file' => $file->id],
                'linkOptions' => [
                    'title' => $file->title,
                ]
            ];
        }),
    ]);
}

if ($stats) {
    echo Progress::widget([
        'percent' => $stats['progress'],
        'label' => 'Progress ' . round($stats['progress']) . '%',
    ]);

    echo Chart::widget([
        'type' => Chart::TYPE_PIE,
        'datasets' => [
            [
                'data' => [
                    'Valid' => $stats['valid'],
                    'Invalid' => $stats['invalid'],
                ]
            ]
        ]
    ]);

    echo GridView::widget([
        'dataProvider' => $stats['dataProvider'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'domain',
            'valid:boolean',
            'expires:date',
        ],
    ]);
}