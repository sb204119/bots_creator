<?php

use backend\modules\bots\models\TgBot;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bots\models\TgBotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Telegram Bots');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-bot-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Tg Bot'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?= Html::a(Yii::t('backend', 'Bot Commands'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'token',
            'service_name',
            'bot_name',
            'welcome_message',
            //'menu',
            //'description',
            //'webhook_url:url',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TgBot $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
