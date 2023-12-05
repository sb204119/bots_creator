<?php

namespace backend\modules\bots\controllers;


use backend\modules\bots\components\Bot;
use backend\modules\bots\models\TgBotSearch;
use Telegram;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\bots\models\TgBot;


class TgBotController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new TgBotSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new TgBot();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $buttons = Yii::$app->request->post('TgBot')['menu'];
            $model->menu = $buttons;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $buttons = Yii::$app->request->post('TgBot')['menu'];

            $model->menu = $buttons;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TgBot::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
    }

    public function actionBot()
    {
        $telegram = new Telegram(env('TOKEN'));
        $text = $telegram->Text();
        $chat_id = $telegram->ChatID();
        $callback_query = $telegram->Callback_Query();

        if (!is_null($text) && !is_null($chat_id)) {
            $bot_data = $telegram->getMe();
            $bot_name = $bot_data['result']['first_name'];
            $tgBot = TgBot::findOne(['bot_name' => $bot_name]);

            if ($tgBot !== null) {
                $buttonsData = json_decode($tgBot->menu, true);

                if ($text == '/start' || $text == 'Hi' || $text == 'Привет' || $text == 'Привіт') {
                    $keyboard = [];

                    foreach ($buttonsData as $button) {
                        if ($button['type'] == 'reply') {
                            $keyboard[] = [$button['text']];
                        }
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

                    $telegram->sendMessage($content);
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

                        $telegram->sendMessage($content);
                    }
                }
            }
        } elseif (!is_null($callback_query)) {
            Yii::error('Ошибка');
        }
    }

}
