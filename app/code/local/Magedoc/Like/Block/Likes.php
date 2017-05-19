<?php
class Magedoc_Like_Block_Likes extends Mage_Core_Block_Template
{
    public $product_Id;
    public $store_Id;
    public $enable_button;

    public function getProductId()
    {
        return $this->getProduct()->getId();
    }

    public function getLikesProduct($product_id, $store_id)
    {
        return Mage::getModel('like/like')->getLikeToProduct($product_id, $store_id);
    }

    public function getStoreId()
    {
        $store = Mage::app()->getStore()->getId();
        return $store;

    }

    public function enableButton() {
        $model = Mage::getModel('like/adding');
        return $model->getResource()->canCustomerLikeByIp($this->getProductId(),
            Mage::getSingleton('customer/session')->getId(),
            Mage::getModel('core/date')->timestamp(time()),
            Mage::helper('core/http')->getRemoteAddr());
    }
}


