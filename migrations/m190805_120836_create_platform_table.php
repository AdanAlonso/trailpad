<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%platform}}`.
 */
class m190805_120836_create_platform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%platform}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%platform}}');
    }
}
