<?php

use yii\db\Migration;

/**
 * Class m240905_065934_update_rbac_permissions
 */
class m240905_065934_update_rbac_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth=Yii::$app->authManager;
        $newPermission=$auth->createPermission('createUser');
        $newPermission->description="add permission CreateUser";
        $auth->add($newPermission);

        $adminRole=$auth->getRole("admin");
        if($adminRole===null){
            echo "Role 'admin' does not exist!";
            return;
        }
        $auth->addChild($adminRole,$newPermission);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth=Yii::$app->authManager;
        $adminRole=$auth->getRole("admin");
        if($adminRole===null){
            echo "Role 'admin' does not exist!";
            return;
        }
        $auth->removeChild($adminRole,$auth->getPermission("createUser"));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240905_065934_update_rbac_permissions cannot be reverted.\n";

        return false;
    }
    */
}
