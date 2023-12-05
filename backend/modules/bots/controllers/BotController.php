<?php

namespace backend\modules\bots\controllers;

use backend\modules\bots\models\TgBot;
use common\components\MethodGenerator;
use Yii;
use yii\web\Controller;
use Telegram;

class BotController extends Controller
{
    private $telegram; // Приватное свойство для хранения экземпляра Telegram

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        // Инициализируем переменную $telegram
        $this->telegram = new Telegram(env('TOKEN')); // Используем полное пространство имен Telegram
    }

    // Отключение CSRF-защиты
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $text = $this->telegram->Text();
        $chat_id = $this->telegram->ChatID();
        $callback_query = $this->telegram->Callback_Query();

        if (!is_null($text) && !is_null($chat_id)) {
            $bot_data = $this->telegram->getMe();
            $bot_name = $bot_data['result']['first_name'];
            $tgBot = TgBot::findOne(['bot_name' => $bot_name]);

            if ($tgBot !== null) {
                $buttonsData = json_decode($tgBot->menu, true);

                if ($text == '/start' || $text == 'Hi' || $text == 'Привет' || $text == 'Привіт') {
                    $keyboard = [];
                    $buttonsPerRow = 3; // Количество кнопок в одной строке
                    $currentRow = [];

                    foreach ($buttonsData as $button) {
                        if ($button['type'] == 'reply') {
                            $currentButton = $button['text'];
                            $currentRow[] = $currentButton;

                            if (count($currentRow) >= $buttonsPerRow) {
                                $keyboard[] = $currentRow;
                                $currentRow = [];
                            }
                        }
                    }

                    if (!empty($currentRow)) {
                        $keyboard[] = $currentRow;
                    }

                    $replyKeyboardMarkup = [
                        'keyboard' => $keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => false,
                    ];

                    $content = [
                        'chat_id' => $chat_id,
                        'text' => $tgBot['welcome_message'],
                        'reply_markup' => json_encode($replyKeyboardMarkup),
                    ];

                    $this->telegram->sendMessage($content);
                } elseif ($text == '/test') {
                    // Это код для отправки инлайн клавиатуры при команде /test
                    $inlineKeyboard = [];

                    foreach ($buttonsData as $button) {
                        if ($button['type'] == 'inline') {
                            $inlineKeyboard[] = [
                                [
                                    'text' => $button['text'],
                                    'callback_data' => $button['command'],
                                ],
                            ];
                        }
                    }

                    if (!empty($inlineKeyboard)) {
                        $content = [
                            'chat_id' => $chat_id,
                            'text' => $tgBot['description'],
                            'reply_markup' => json_encode(['inline_keyboard' => $inlineKeyboard]),
                        ];

                        $this->telegram->sendMessage($content);
                    }
                }
            }
        } elseif (!is_null($callback_query)) {
            Yii::error('Ошибка');
        }
    }

    public function actionTest()
    {
        $generator = new MethodGenerator();
        $controllerName = 'BotCommandsController';
        $methodName = 'actionTest';
        $parameters = ['$param1', '$param2'];
        $modelNamespace = 'backend\modules\bots\models'; // Пространство имен вашей модели
        $modelClass = 'TgBot'; // Имя класса модели без пространства имен
        $methodBody = 'return $param1 + $param2 + $model->property;';

        $generator->generateMethod($controllerName, $methodName, $parameters, $modelNamespace, $modelClass, $methodBody);
    }
}
