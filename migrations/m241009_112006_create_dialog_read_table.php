<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialog_read}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%dialog}}`
 * - `{{%user}}`
 */
class m241009_112006_create_dialog_read_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dialog_read}}', [
            'id' => $this->primaryKey(),
            'dialog_id' => $this->integer(),
            'user_to' => $this->integer(),
            'read' => $this->integer(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `dialog_id`
        $this->createIndex(
            '{{%idx-dialog_read-dialog_id}}',
            '{{%dialog_read}}',
            'dialog_id'
        );

        // add foreign key for table `{{%dialog}}`
        $this->addForeignKey(
            '{{%fk-dialog_read-dialog_id}}',
            '{{%dialog_read}}',
            'dialog_id',
            '{{%dialog}}',
            'id',
        );

        // creates index for column `user_to`
        $this->createIndex(
            '{{%idx-dialog_read-user_to}}',
            '{{%dialog_read}}',
            'user_to'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-dialog_read-user_to}}',
            '{{%dialog_read}}',
            'user_to',
            '{{%user}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%dialog}}`
        $this->dropForeignKey(
            '{{%fk-dialog_read-dialog_id}}',
            '{{%dialog_read}}'
        );

        // drops index for column `dialog_id`
        $this->dropIndex(
            '{{%idx-dialog_read-dialog_id}}',
            '{{%dialog_read}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-dialog_read-user_to}}',
            '{{%dialog_read}}'
        );

        // drops index for column `user_to`
        $this->dropIndex(
            '{{%idx-dialog_read-user_to}}',
            '{{%dialog_read}}'
        );

        $this->dropTable('{{%dialog_read}}');
    }
}
