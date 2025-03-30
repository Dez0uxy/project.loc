<?php

use yii\db\Migration;

/**
 * Class m220531_132945_alter_table_warehouse_add_price_updated
 */
class m220531_132945_alter_table_warehouse_add_price_updated extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%warehouse}}', 'price_updated', $this->timestamp()->null()->after('ts'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%warehouse}}', 'price_updated');
    }
}
