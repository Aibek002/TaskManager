<?php

use yii\db\Migration;

/**
 * Class m241008_103426_add_foreign_key_status_table
 */
class m241008_103426_add_foreign_key_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Проверяем, существует ли уже внешний ключ
        try {
            $this->addForeignKey(
                'fk_status_type', // Уникальное имя внешнего ключа
                'status', // Дочерняя таблица
                'type', // Столбец дочерней таблицы
                'status_type', // Родительская таблица
                'id', // Столбец родительской таблицы
            );
        } catch (\yii\db\Exception $e) {
            echo "Foreign key 'fk_status_type' already exists or an error occurred: " . $e->getMessage() . "\n";
        }

        try {
            $this->addForeignKey(
                'fk_status_task_id',
                'status',
                'task_id',
                'post',
                'id',
            );
        } catch (\yii\db\Exception $e) {
            echo "Foreign key 'fk_status_task_id' already exists or an error occurred: " . $e->getMessage() . "\n";
        }
    }

    public function safeDown()
    {
        // Удаление внешнего ключа при откате миграции
        $this->dropForeignKey(
            'fk_status_type',
            'status'
        );
        $this->dropForeignKey(
            'fk_status_task_id',
            'status'
        );
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_103426_add_foreign_key_status_table cannot be reverted.\n";

        return false;
    }
    */
}
