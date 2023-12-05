<?php

use yii\db\Migration;

/**
 * Handles the creation of table `f_bot`.
 */
class m231016_054115_create_f_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('f_bot', [
            'id' => $this->primaryKey(),
            'token' => $this->string(191)->notNull(),
            'service_name' => $this->string(191)->notNull(),
			'bot_name' => $this->string(191)->notNull(),
			'welcome_message' => $this->string(191)->notNull(),
			'menu' => $this->string(191)->notNull(),
			'description' => $this->string(191)->notNull(),
			'webhook_url' => $this->string(191)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('f_bot');
    }
}
