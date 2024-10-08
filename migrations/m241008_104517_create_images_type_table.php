<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images_type}}`.
 */
class m241008_104517_create_images_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images_type}}');
    }
}
