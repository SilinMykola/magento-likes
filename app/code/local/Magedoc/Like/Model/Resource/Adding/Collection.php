<?php
class Magedoc_Like_Model_Resource_Adding_Collection extends  Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this-> _init('like/adding');
    }

    public function addProductName()
    {
        $entityTypeId = Mage::getModel('eav/entity')
            ->setType('catalog_product')
            ->getTypeId();
        $prodNameAttrId = Mage::getModel('eav/entity_attribute')
            ->loadByCode($entityTypeId, 'name')
            ->getAttributeId();
        $catalogTableName = Mage::getSingleton('core/resource')->getTableName('catalog/product');

        $product =  Mage::getResourceModel('catalog/product')->getAttribute($prodNameAttrId);
        $catalogVarcharTableName = $product->getBackend()->getTable();

        $this->getSelect()
            ->joinLeft(
                array('prod' => $catalogTableName),
                'prod.entity_id = main_table.product_id',
                array('sku')
            )
            ->joinLeft(
                array('cpev' => $catalogVarcharTableName),
                'cpev.entity_id=prod.entity_id AND cpev.attribute_id='.$prodNameAttrId.' ',
                array('product_name' => 'value')
            );

        return $this;
    }

    public function addCustomerFullName()
    {
        $eav = Mage::getModel('eav/entity_attribute');
        $firstnameAttr = $eav->loadByCode('1', 'firstname')->getAttributeId();
        $lastnameAttr = $eav->loadByCode('1', 'lastname')->getAttributeId();

        $customerTableName = $eav->getBackend()->getTable();

        $this->getSelect()
            ->joinLeft(
                array('ce1' => $customerTableName),
                'ce1.entity_id=main_table.customer_id AND ce1.attribute_id='.$firstnameAttr.'',
                array('firstname' => 'value'))

            ->joinLeft(
                array('ce2' => $customerTableName),
                'ce2.entity_id=main_table.customer_id AND ce2.attribute_id='.$lastnameAttr.'',
                array('lastname' => 'value'));
        $this->addExpressionFieldToSelect('fullname',"IFNULL(CONCAT({{firstname}},' ',{{lastname}}), 'Guest') ", array('firstname' => 'ce1.value', 'lastname'=> 'ce2.value'));

            //->columns(new Zend_Db_Expr("IFNULL(CONCAT(`ce1`.`value`, ' ',`ce2`.`value`), 'Guest') AS fullname"));
        return $this;
    }
}

