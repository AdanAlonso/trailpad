<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%game}}`.
 */
class m190812_223737_add_cover_column_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%game}}', 'cover', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%game}}', 'cover');
    }
}
