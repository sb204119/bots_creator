<?php

namespace backend\modules\bots\models;

use Yii;

/**
 * This is the model class for table "f_bot".
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
class FBot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'service_name', 'bot_name', 'welcome_message', 'menu', 'description', 'webhook_url'], 'required'],
            [['token', 'service_name', 'bot_name', 'welcome_message', 'menu', 'description', 'webhook_url'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'token' => Yii::t('app', 'Token'),
            'service_name' => Yii::t('app', 'Service Name'),
            'bot_name' => Yii::t('app', 'Bot Name'),
            'welcome_message' => Yii::t('app', 'Welcome Message'),
            'menu' => Yii::t('app', 'Menu'),
            'description' => Yii::t('app', 'Description'),
            'webhook_url' => Yii::t('app', 'Webhook Url'),
        ];
    }
}
