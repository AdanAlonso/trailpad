<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%game}}`.
 */
class m190813_123225_add_timestamp_columns_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%game}}', 'created_at', $this->integer());
        $this->addColumn('{{%game}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%game}}', 'created_at');
        $this->dropColumn('{{%game}}', 'updated_at');
    }
}
