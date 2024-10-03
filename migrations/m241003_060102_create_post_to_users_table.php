<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_to_users}}`.
 */
class m241003_060102_create_post_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_to_users}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_to_users}}');
    }
}
