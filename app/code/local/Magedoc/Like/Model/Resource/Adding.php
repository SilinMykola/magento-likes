<?php

class Magedoc_Like_Model_Resource_Adding extends Magedoc_Like_Model_Resource_Abstract
{
    protected $tableName;
    public function _construct()
    {
        $this->_init('like/product_like', 'id');
    }

    public function addingLike($product_id, $customer_id, $customer_ip)
    {
        $timestamp = Mage::getModel('core/date')->timestamp(time());
        $store_id = Mage::app()->getStore()->getId();

        if ($this->canCustomerLikeByIp($product_id, $customer_id, $timestamp, $customer_ip)) {
            $data = array('customer_id'=> $customer_id,'product_id'=> $product_id,'customer_ip' => $customer_ip, 'created_at' => $timestamp, 'store_id' => $store_id);
            Mage::getModel('like/adding')->setData($data)->save();
            return true;
        } else {
            return false;
        }
    }

    public function canCustomerLikeByIp($product_id, $customer_id, $timestamp, $customer_ip)
    {
        $sql = $this->getReadConnection()
            ->select('created_at')
            ->from($this->getMainTable())
            ->where('product_id=?', $product_id)
            ->where('customer_id=?', $customer_id)
            ->where('customer_ip=?', $customer_ip)
            ->order('created_at DESC')
            ->limit(1);
        $time = $this->getReadConnection()
            ->fetchRow($sql);

        if ($time) {
                $how = $timestamp - strtotime($time['created_at']);
                if (!$customer_id) {
                    if ($how < 24*60*60) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
        } else {
            return true;
        }
    }

}