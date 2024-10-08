<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m241008_105420_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'path' => $this->string(),
            'alt' => $this->string(),
        ]);

        // creates index for column `type`
        $this->createIndex(
            '{{%idx-images-type}}',
            '{{%images}}',
            'type'
        );

        // add foreign key for table `{{%images_type}}`
        $this->addForeignKey(
            '{{%fk-images-type}}',
            '{{%images}}',
            'type',
            '{{%images_type}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%images_type}}`
        $this->dropForeignKey(
            '{{%fk-images-type}}',
            '{{%images}}'
        );

        // drops index for column `type`
        $this->dropIndex(
            '{{%idx-images-type}}',
            '{{%images}}'
        );

        $this->dropTable('{{%images}}');
    }
}
