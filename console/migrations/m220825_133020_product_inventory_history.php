<?php

use yii\db\Schema;
use yii\db\Migration;

class m220825_133020_product_inventory_history extends Migration
{

    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM';

        $this->createTable(
            '{{%product_inventory_history}}',
            [
                'id'            => $this->primaryKey(11)->unsigned(),
                'id_product'    => $this->integer(11)->unsigned()->notNull(),
                'id_order'      => $this->integer(11)->unsigned()->null()->defaultValue(null),
                'id_user'       => $this->integer(11)->unsigned()->null()->defaultValue(null),
                'status_prev'   => $this->integer(11)->null()->defaultValue(null),
                'status_new'    => $this->integer(11)->null()->defaultValue(null),
                'quantity_prev' => $this->integer(11)->null()->defaultValue(null),
                'quantity_new'  => $this->integer(11)->null()->defaultValue(null),
                'created_at'    => $this->timestamp()->null()->defaultValue(null),
                'updated_at'    => $this->timestamp()->null()->defaultValue(null),
            ], $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_inventory_history}}');
    }
}
