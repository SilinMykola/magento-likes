<?php
class Magedoc_Like_Model_Adding extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('like/adding');
    }

    public function addLike($product_id)
    {
        $customer_id = $this->getCustomerId();
        $customer_ip = $this->getCustomerIp();
        return $this->getResource()->addingLike($product_id, $customer_id, $customer_ip);
    }

    public function getCustomerId()
    {
        if (Mage::getSingleton('customer/session')->getId()) {
            return Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else {
            return "0";
        }
    }

    public function getCustomerIp()
    {
        if (Mage::app()->getRequest()->getServer('HTTP_X_FORWARDED_FOR')) {
            return Mage::app()->getRequest()->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            return Mage::helper('core/http')->getRemoteAddr();
        }
    }
}