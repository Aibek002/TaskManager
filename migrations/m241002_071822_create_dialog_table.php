<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialog}}`.
 */
class m241002_071822_create_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dialog}}', [
            'id' => $this->primaryKey(),
            'user_from' => $this->integer(),
            'user_to' => $this->integer(),
            'task_id' => $this->integer(),
            'text' => $this->text(),
            'read' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dialog}}');
    }
}
