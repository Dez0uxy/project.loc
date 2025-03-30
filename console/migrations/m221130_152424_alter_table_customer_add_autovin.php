<?php

use yii\db\Migration;

/**
 * Class m221130_152424_alter_table_customer_add_autovin
 */
class m221130_152424_alter_table_customer_add_autovin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'autovin', $this->string(255)->null()->defaultValue(null)->after('automodel'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'autovin');
    }
}
