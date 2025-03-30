<?php

use yii\db\Migration;

/**
 * Class m230207_095452_alter_table_product_add_updated_at
 */
class m230207_095452_alter_table_product_add_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'created_at', $this->timestamp()->null()->defaultValue(null));
        $this->addColumn('{{%product}}', 'updated_at', $this->timestamp()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'created_at');
        $this->dropColumn('{{%product}}', 'updated_at');
    }
}
