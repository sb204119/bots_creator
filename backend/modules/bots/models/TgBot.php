<?php

namespace backend\modules\bots\models;

use Yii;

/**
 * This is the model class for table "tg_bot".
 *
 * @property int $id
 * @property string $token
 * @property string $service_name
 * @property string $bot_name
 * @property string $welcome_message
 * @property string $menu
 * @property string $description
 * @property string $webhook_url
 */
class TgBot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tg_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'service_name', 'bot_name', 'welcome_message', 'menu', 'description', 'webhook_url'], 'required'],
            [['token', 'service_name', 'bot_name', 'welcome_message', 'description', 'webhook_url'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'token' => Yii::t('backend', 'Token'),
            'service_name' => Yii::t('backend', 'Service Name'),
            'bot_name' => Yii::t('backend', 'Bot Name'),
            'welcome_message' => Yii::t('backend', 'Welcome Message'),
            'menu' => Yii::t('backend', 'Menu'),
            'description' => Yii::t('backend', 'Description'),
            'webhook_url' => Yii::t('backend', 'Webhook Url'),
        ];
    }
}
