<?php


namespace app\assets;


use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $sourcePath = '@bower/chart-js/dist';

    public $css = [
        'Chart.min.css'
    ];

    public $js = [
        'Chart.min.js'
    ];
}