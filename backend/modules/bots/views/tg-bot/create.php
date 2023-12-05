<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bots\models\TgBot */

$this->title = Yii::t('frontend', 'Create Tg Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Tg Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-bot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
