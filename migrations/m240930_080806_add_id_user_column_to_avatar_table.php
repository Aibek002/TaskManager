<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%avatar}}`.
 */
class m240930_080806_add_id_user_column_to_avatar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%avatar}}', 'id_user', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%avatar}}', 'id_user');
    }
}
