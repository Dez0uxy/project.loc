<?php

use yii\db\Migration;

/**
 * Class m231124_184812_order_product_add_id_warehouse
 */
class m231124_184812_order_product_add_id_warehouse extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_product}}', 'id_warehouse', $this->integer(11)->null()->defaultValue(null)->after('id_product'));
        $this->addColumn('{{%income_product}}', 'id_warehouse', $this->integer(11)->null()->defaultValue(null)->after('id_product'));
        $this->addColumn('{{%product_inventory_history}}', 'id_warehouse', $this->integer(11)->null()->defaultValue(null)->after('id_product'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_product}}', 'id_warehouse');
        $this->dropColumn('{{%income_product}}', 'id_warehouse');
        $this->dropColumn('{{%product_inventory_history}}', 'id_warehouse');
    }
}
