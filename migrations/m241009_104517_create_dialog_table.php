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
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'post_id' => $this->integer(),
        ]);

        // creates index for column `user_from`
        $this->createIndex(
            '{{%dialog_idx_user_id}}',
            '{{%dialog}}',
            'user_from'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%dialog_fk_user_id}}',
            '{{%dialog}}',
            'user_from',
            '{{%user}}',
            'id',
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%dialog_idx_post_id}}',
            '{{%dialog}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%dialog_fk_post_id}}',
            '{{%dialog}}',
            'post_id',
            '{{%post}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%dialog_fk_user_id}}',
            '{{%dialog}}'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            '{{%dialog_idx_user_id}}',
            '{{%dialog}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%dialog_fk_post_id}}',
            '{{%dialog}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%dialog_idx_post_id}}',
            '{{%dialog}}'
        );

        $this->dropTable('{{%dialog}}');
    }
}
