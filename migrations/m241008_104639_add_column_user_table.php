<?php

use yii\db\Migration;

/**
 * Class m241008_104639_add_column_user_table
 */
class m241008_104639_add_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241008_104639_add_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_104639_add_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
