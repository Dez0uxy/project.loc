<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%warehouse_place}}`.
 */
class m240411_115537_create_warehouse_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%warehouse_place}}', [
            'id'           => $this->primaryKey(),
            'id_warehouse' => $this->integer()->notNull(),
            'name'         => $this->string(32),
        ]);

        $this->addColumn('{{%product_quantity}}', 'id_warehouse_place', $this->integer(11)->null()->defaultValue(null)->after('id_warehouse'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_quantity}}', 'id_warehouse_place');

        $this->dropTable('{{%warehouse_place}}');
    }
}
