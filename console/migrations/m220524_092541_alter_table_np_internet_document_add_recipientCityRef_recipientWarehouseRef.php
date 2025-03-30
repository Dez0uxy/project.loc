<?php

use yii\db\Migration;

/**
 * Class m220524_092541_alter_table_np_internet_document_add_recipientCityRef_recipientWarehouseRef
 */
class m220524_092541_alter_table_np_internet_document_add_recipientCityRef_recipientWarehouseRef extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%np_internet_document}}', 'id_order', $this->integer(11)->unsigned()->after('id'));
        $this->addColumn('{{%np_internet_document}}', 'recipientCityRef', $this->string()->defaultValue(null)->after('recipientCity'));
        $this->addColumn('{{%np_internet_document}}', 'recipientWarehouseRef', $this->string()->defaultValue(null)->after('recipientWarehouse'));

        $this->addColumn('{{%np_internet_document}}', 'CostOnSite', $this->string()->defaultValue(null)->after('TrackingNumber'));
        $this->addColumn('{{%np_internet_document}}', 'EstimatedDeliveryDate', $this->string()->defaultValue(null)->after('CostOnSite'));
        $this->addColumn('{{%np_internet_document}}', 'Ref', $this->string()->defaultValue(null)->after('EstimatedDeliveryDate'));
        $this->addColumn('{{%np_internet_document}}', 'TypeDocument', $this->string()->defaultValue(null)->after('Ref'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%np_internet_document}}', 'id_order');
        $this->dropColumn('{{%np_internet_document}}', 'recipientCityRef');
        $this->dropColumn('{{%np_internet_document}}', 'recipientWarehouseRef');

        $this->dropColumn('{{%np_internet_document}}', 'CostOnSite');
        $this->dropColumn('{{%np_internet_document}}', 'EstimatedDeliveryDate');
        $this->dropColumn('{{%np_internet_document}}', 'Ref');
        $this->dropColumn('{{%np_internet_document}}', 'TypeDocument');
    }
}
