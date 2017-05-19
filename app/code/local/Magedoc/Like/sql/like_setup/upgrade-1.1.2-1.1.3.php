<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$connection = $installer->getConnection();

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('like/product_like'),
        'store_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 1,
            'nullable' => false,
            'default' => 0,
            'comment' => 'Store Id to product'
        ));

$installer->endSetup();
