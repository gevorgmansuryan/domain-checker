<?php

/**
 * @var $this yii\web\View
 * @var \app\models\Server $server
 * @var \app\models\WhoisSandbox $sandbox
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Server learn - .' . $server->tld;
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin() ?>
<div class="panel panel-default">
    <div class="panel-heading">Sandbox</div>
    <div class="panel-body">
        <?= $form->field($sandbox, 'domain')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Test request', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
        <?php if (!empty($sandbox->payload)) : ?>
            <div class="form-group">
                <?= Html::activeLabel($sandbox, 'available') ?>
                <div><?= Yii::$app->formatter->asBoolean($sandbox->available) ?></div>
            </div>
            <div class="form-group">
                <?= Html::activeLabel($sandbox, 'expires') ?>
                <div><?= Yii::$app->formatter->asDate($sandbox->expires) ?></div>
            </div>
            <div class="form-group">
                <?= Html::activeLabel($sandbox, 'payload') ?>
                <div><?= nl2br($sandbox->payload) ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $form = ActiveForm::begin() ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?></div>
    <div class="panel-body">
        <?= $form->field($server, 'available_string')->textInput() ?>
        <?= $form->field($server, 'expire_string')->textInput() ?>
        <?= $form->field($server, 'whois')->textInput() ?>
        <?= $form->field($server, 'domain_only')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>