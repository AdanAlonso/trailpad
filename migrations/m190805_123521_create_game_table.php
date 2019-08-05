<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%game}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%platform}}`
 */
class m190805_123521_create_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%game}}', [
            'id' => $this->primaryKey(),
            'platform_id' => $this->integer()->notNull(),
            'title' => $this->string(),
        ]);

        // creates index for column `platform_id`
        $this->createIndex(
            '{{%idx-game-platform_id}}',
            '{{%game}}',
            'platform_id'
        );

        // add foreign key for table `{{%platform}}`
        $this->addForeignKey(
            '{{%fk-game-platform_id}}',
            '{{%game}}',
            'platform_id',
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
        // drops foreign key for table `{{%platform}}`
        $this->dropForeignKey(
            '{{%fk-game-platform_id}}',
            '{{%game}}'
        );

        // drops index for column `platform_id`
        $this->dropIndex(
            '{{%idx-game-platform_id}}',
            '{{%game}}'
        );

        $this->dropTable('{{%game}}');
    }
}
