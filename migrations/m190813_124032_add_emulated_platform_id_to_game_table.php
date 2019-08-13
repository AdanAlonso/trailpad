<?php

use yii\db\Migration;

/**
 * Class m190813_124032_add_emulated_platform_id_to_game_table
 */
class m190813_124032_add_emulated_platform_id_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%game}}', 'emulated_platform_id', $this->integer());

        // creates index for column `emulated_platform_id`
        $this->createIndex(
            '{{%idx-game-emulated_platform_id}}',
            '{{%game}}',
            'emulated_platform_id'
        );

        // add foreign key for table `{{%platform}}`
        $this->addForeignKey(
            '{{%fk-game-emulated_platform_id}}',
            '{{%game}}',
            'emulated_platform_id',
            '{{%platform}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%game}}', 'emulated_platform_id');
    }
}
