<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m241002_070935_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'task_id' => $this->integer(),
            'status_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
