<?php

use yii\db\Schema;
use yii\db\Migration;

class m220602_100624_cashdesk extends Migration
{

    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM';

        $this->createTable(
            '{{%cashdesk}}',
            [
                'id'         => $this->primaryKey(11)->unsigned(),
                'id_user'    => $this->integer(10)->unsigned()->null()->defaultValue(null),
                'id_order'   => $this->integer(10)->unsigned()->null()->defaultValue(null),
                'amount'     => $this->double(10, 2)->notNull(),
                'note'       => $this->string(255)->null()->defaultValue(null),
                'created_at' => $this->timestamp()->null()->defaultValue(null),
                'updated_at' => $this->timestamp()->null()->defaultValue(null),
            ], $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%cashdesk}}');
    }
}
