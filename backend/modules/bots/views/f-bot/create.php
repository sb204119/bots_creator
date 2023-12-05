<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bots\models\FBot */

$this->title = Yii::t('frontend', 'Create F Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'F Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fbot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
