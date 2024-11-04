<?php

use yii\db\Migration;

/**
 * Class m241015_103744_add_rbac_role
 */
class m241015_103744_add_rbac_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $manager = $auth->createRole('manager');
        $manager->description = 'Manager';
        $auth->add($manager);
        $createPost = $auth->getPermission('createPost');
        if ($createPost) {
            $auth->addChild($manager, $createPost);
        } else {
            echo "Permission 'createPost' doesn't exist.";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $manager = $auth->getRole('manager');
        $createPost = $auth->getPermission('createPost');
        if ($manager) {
            $auth->removeChild($manager, $createPost);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_103744_add_rbac_role cannot be reverted.\n";

        return false;
    }
    */
}
