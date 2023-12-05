<?php

use yii\helpers\Url;

$this->title = Yii::t('backend', 'Bots');

$this->params['breadcrumbs'][] = $this->title;

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <a href="<?= Url::to(['/bots/tg-bot'], false) ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fab fa-telegram"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo Yii::t('backend', 'Telegram Bot') ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= Url::to(['/bots/v-bot'], true) ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            <i class="fab fa-viber"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo Yii::t('backend', 'Viber Bot') ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= Url::to(['/bots/f-bot'], true) ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary">
                            <i class="fab fa-facebook"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo Yii::t('backend', 'Facebook Bot') ?></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
