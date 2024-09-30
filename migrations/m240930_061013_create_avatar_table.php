<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%avatar}}`.
 */
class m240930_061013_create_avatar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%avatar}}', [
            'id' => $this->primaryKey(),
            'imageAvatar' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%avatar}}');
    }
}
