<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_to_users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%post}}`
 */
class m241008_101002_create_post_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_to_users}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-post_to_users-user_id}}',
            '{{%post_to_users}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post_to_users-user_id}}',
            '{{%post_to_users}}',
            'user_id',
            '{{%user}}',
            'id',
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_to_users-post_id}}',
            '{{%post_to_users}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-post_to_users-post_id}}',
            '{{%post_to_users}}',
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
            '{{%fk-post_to_users-user_id}}',
            '{{%post_to_users}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-post_to_users-user_id}}',
            '{{%post_to_users}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-post_to_users-post_id}}',
            '{{%post_to_users}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_to_users-post_id}}',
            '{{%post_to_users}}'
        );

        $this->dropTable('{{%post_to_users}}');
    }
}
