<?php

use yii\db\Migration;

/**
 * Class m221125_151344_alter_table_product_add_prom_export
 */
class m221125_151344_alter_table_product_add_prom_export extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'prom_export', $this->tinyInteger(1)->null()->defaultValue(null)->after('id_image'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'prom_export');
    }

}
