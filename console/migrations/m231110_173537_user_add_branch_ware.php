<?php

use yii\db\Migration;

/**
 * Class m231110_173537_user_add_branch_ware
 */
class m231110_173537_user_add_branch_ware extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'id_branch', $this->integer(11)->null()->defaultValue(null)->after('username'));
        $this->addColumn('{{%user}}', 'id_warehouse', $this->integer(11)->null()->defaultValue(null)->after('id_branch'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'id_branch');
        $this->dropColumn('{{%user}}', 'id_warehouse');
    }
}
