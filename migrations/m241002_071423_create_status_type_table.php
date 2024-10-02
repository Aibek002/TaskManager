<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status_type}}`.
 */
class m241002_071423_create_status_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status_type}}', [
            'id' => $this->primaryKey(),
            'status_type' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status_type}}');
    }
}
