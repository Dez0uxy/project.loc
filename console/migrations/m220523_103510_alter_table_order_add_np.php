<?php

use yii\db\Migration;

/**
 * Class m220523_103510_alter_table_order_add_np
 */
class m220523_103510_alter_table_order_add_np extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'np_city_ref', $this->string()->defaultValue(null)->after('np_city'));
        $this->addColumn('{{%order}}', 'np_region', $this->string()->defaultValue(null)->after('np_city_ref'));
        $this->addColumn('{{%order}}', 'np_region_ref', $this->string()->defaultValue(null)->after('np_region'));
        $this->addColumn('{{%order}}', 'np_warehouse_ref', $this->string()->defaultValue(null)->after('np_warehouse'));

        $this->addColumn('{{%customer}}', 'carrier_city_ref', $this->string()->defaultValue(null)->after('carrier_city'));
        $this->addColumn('{{%customer}}', 'carrier_region', $this->string()->defaultValue(null)->after('carrier_city_ref'));
        $this->addColumn('{{%customer}}', 'carrier_region_ref', $this->string()->defaultValue(null)->after('carrier_region'));
        $this->addColumn('{{%customer}}', 'carrier_branch_ref', $this->string()->defaultValue(null)->after('carrier_branch'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'np_city_ref');
        $this->dropColumn('{{%order}}', 'np_region');
        $this->dropColumn('{{%order}}', 'np_region_ref');
        $this->dropColumn('{{%order}}', 'np_warehouse_ref');

        $this->dropColumn('{{%customer}}', 'carrier_city_ref');
        $this->dropColumn('{{%customer}}', 'carrier_region');
        $this->dropColumn('{{%customer}}', 'carrier_region_ref');
        $this->dropColumn('{{%customer}}', 'carrier_branch_ref');
    }
}
