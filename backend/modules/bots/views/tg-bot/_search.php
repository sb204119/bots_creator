<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bots\models\TgBotSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tg-bot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'token') ?>

    <?= $form->field($model, 'service_name') ?>

    <?= $form->field($model, 'bot_name') ?>

    <?= $form->field($model, 'welcome_message') ?>

    <?php // echo $form->field($model, 'menu') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'webhook_url') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('frontend', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
