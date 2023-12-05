<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bots\models\VBot */

$this->title = Yii::t('frontend', 'Create V Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'V Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vbot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
