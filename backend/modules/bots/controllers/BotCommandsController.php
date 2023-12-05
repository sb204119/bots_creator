<?php
use backend\modules\bots\models\TgBot;
class BotCommandsController {
    public function actionTest($param1, $param2) {
        $model = new TgBot();
        return $param1 + $param2 + $model->property;
    }
}
