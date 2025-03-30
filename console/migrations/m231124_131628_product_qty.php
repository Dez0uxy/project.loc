<?php

use yii\db\Migration;

/**
 * Class m231124_131628_product_qty
 */
class m231124_131628_product_qty extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM';

        $this->createTable(
            '{{%product_quantity}}',
            [
                'id'           => $this->primaryKey(11)->unsigned(),
                'id_product'   => $this->integer(11)->unsigned()->notNull(),
                'id_warehouse' => $this->integer(11)->unsigned()->null()->defaultValue(null),
                'count'        => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
                'price'        => $this->float()->null()->defaultValue(null),
                'ware_place'   => $this->string(255)->null()->defaultValue(null),
                'created_at'   => $this->timestamp()->null()->defaultValue(null),
                'updated_at'   => $this->timestamp()->null()->defaultValue(null),
            ], $tableOptions
        );
        $this->createIndex('idx-id_product', '{{%product_quantity}}', 'id_product');
        $this->createIndex('idx-id_warehouse', '{{%product_quantity}}', 'id_warehouse');
        //$this->createIndex('idx-product_warehouse', '{{%product_quantity}}', ['id_product', 'id_warehouse']);

    }

    public function safeDown()
    {
        $this->dropIndex('idx-id_product', '{{%product_quantity}}');
        $this->dropIndex('idx-id_warehouse', '{{%product_quantity}}');
        //$this->dropIndex('idx-product_warehouse', '{{%product_quantity}}');

        $this->dropTable('{{%product_quantity}}');
    }
}
