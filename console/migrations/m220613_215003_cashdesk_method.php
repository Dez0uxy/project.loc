<?php

use yii\db\Schema;
use yii\db\Migration;

class m220613_215003_cashdesk_method extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM';

        $this->createTable(
            '{{%cashdesk_method}}',
            [
                'id'   => $this->primaryKey(11)->unsigned(),
                'name' => $this->string(255)->null()->defaultValue(null),
            ], $tableOptions
        );

        $this->batchInsert('{{%cashdesk_method}}',
            ["id", "name"],
            [
                [
                    'id'   => '1',
                    'name' => 'Готівка',
                ],
                [
                    'id'   => '2',
                    'name' => 'Картка Приват 0258',
                ],
                [
                    'id'   => '3',
                    'name' => 'Картка Моно 1236',
                ],
            ]
        );

        // id_method
        $this->addColumn('{{%cashdesk}}', 'id_method', $this->integer(10)->unsigned()->defaultValue(null)->after('id_order'));

    }

    public function safeDown()
    {
        $this->dropTable('{{%cashdesk_method}}');
        $this->dropColumn('{{%cashdesk}}', 'id_method');
    }
}
