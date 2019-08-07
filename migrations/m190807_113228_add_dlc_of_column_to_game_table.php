<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%game}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%game}}`
 */
class m190807_113228_add_dlc_of_column_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%game}}', 'dlc_of_id', $this->integer());

        // creates index for column `dlc_of_id`
        $this->createIndex(
            '{{%idx-game-dlc_of_id}}',
            '{{%game}}',
            'dlc_of_id'
        );

        // add foreign key for table `{{%game}}`
        $this->addForeignKey(
            '{{%fk-game-dlc_of_id}}',
            '{{%game}}',
            'dlc_of_id',
            '{{%game}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%game}}`
        $this->dropForeignKey(
            '{{%fk-game-dlc_of_id}}',
            '{{%game}}'
        );

        // drops index for column `dlc_of_id`
        $this->dropIndex(
            '{{%idx-game-dlc_of_id}}',
            '{{%game}}'
        );

        $this->dropColumn('{{%game}}', 'dlc_of_id');
    }
}
