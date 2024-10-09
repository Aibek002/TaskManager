<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialog}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%post}}`
 */
class m241009_104517_create_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dialog}}', [
            'id' => $this->primaryKey(),
            'user_from' => $this->integer(),
            'comments' => $this->text(),
            'date' => $this->timestamp()()->defaultExpression('CURRENT_TIMESTAMP'),
            'post_id' => $this->integer(),
        ]);

        // creates index for column `user_from`
        $this->createIndex(
            '{{%idx-dialog-user_from}}',
            '{{%dialog}}',
            'user_from'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-dialog-user_from}}',
            '{{%dialog}}',
            'user_from',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-dialog-post_id}}',
            '{{%dialog}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-dialog-post_id}}',
            '{{%dialog}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-dialog-user_from}}',
            '{{%dialog}}'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            '{{%idx-dialog-user_from}}',
            '{{%dialog}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-dialog-post_id}}',
            '{{%dialog}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-dialog-post_id}}',
            '{{%dialog}}'
        );

        $this->dropTable('{{%dialog}}');
    }
}
