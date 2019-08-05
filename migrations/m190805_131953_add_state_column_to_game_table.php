<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%game}}`.
 */
class m190805_131953_add_state_column_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%game}}', 'state', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%game}}', 'state');
    }
}
