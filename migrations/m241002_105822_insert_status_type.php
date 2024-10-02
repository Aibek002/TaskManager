<?php

use yii\db\Migration;

/**
 * Class m241002_105822_insert_status_type
 */
class m241002_105822_insert_status_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('status_type', ['status_type'], [['create'], ['active'], ['take'], ['cancel'], ['compare']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('status_type', ['status_type'=>['create', 'active', 'take', 'cancel', 'compare']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241002_105822_insert_status_type cannot be reverted.\n";

        return false;
    }
    */
}
