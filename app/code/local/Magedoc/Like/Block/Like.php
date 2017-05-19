<?php
class Magedoc_Like_Block_Like extends Mage_Core_Block_Template
{
    public $product_Id;
    public $store_Id;
    public $enable_button;

    public function __construct()
    {
        parent::_construct();
        $this->product_Id = Mage::registry('current_product')->getId();
        $this->store_Id = Mage::app()->getStore()->getId();
//        $this->enable_button = Mage::getModel('like/adding')->getResource()->canCustomerLikeByIp($this->product_Id,
//            Mage::getModel('like/adding')->getCustomerId(),
//            Mage::getModel('core/date')->timestamp(time()),
//            Mage::getModel('like/adding')->getCustomerIp());
    }

    public function getLikesProduct()
    {
        $this->product_Id = Mage::registry('current_product')->getId();
        $this->store_Id = Mage::app()->getStore()->getId();
        $likesCount = Mage::getModel('like/like')->getLikeToProduct($this->product_Id, $this->store_Id);

        return $likesCount;
    }
    public function enableButton() {

        $model = Mage::getModel('like/adding');
        return $model->getResource()->canCustomerLikeByIp($this->product_Id,
                                                                $model->getCustomerId(),
                                                                Mage::getModel('core/date')->timestamp(time()),
                                                                $model->getCustomerIp());
    }
}