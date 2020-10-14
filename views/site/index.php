<?php

/**
 * @var $this yii\web\View
 * @var DomainFile $model
 * @var array $widgets
 */

use app\models\DomainFile;
use app\models\Server;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;

foreach ([
             Server::STATUS_SERVER_NOT_WORKING => 'alert-danger',
             Server::STATUS_CAN_NOT_PARSE_AVAILABLE => 'alert-warning',
             Server::STATUS_CAN_NOT_PARSE_EXPIRED => 'alert-warning',
             Server::STATUS_EXPIRED_MAY_NOT_CORRECT => 'alert-info',
         ] as $status => $class) {
    if ($widgets[$status]) {
        echo Alert::widget([
            'options' => [
                'class' => $class,
            ],
            'body' => sprintf(
                    '%s servers %s. %s',
                    $widgets[$status],
                    Server::LEARNING_STATUS_LABELS[$status],
                    Html::a('Fix all', ['/learning', 'ServerSearch' => ['status' => $status]])
            ),
        ]);
    }
}



$form = ActiveForm::begin() ?>

<?= $form->field($model, 'file_name')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>