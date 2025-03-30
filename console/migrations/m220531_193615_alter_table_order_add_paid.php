<?php

use yii\db\Migration;

/**
 * Class m220531_193615_alter_table_order_add_paid
 */
class m220531_193615_alter_table_order_add_paid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'paid', $this->double(10, 2)->null()->defaultValue(null)->after('is_paid'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'paid');
    }

}
