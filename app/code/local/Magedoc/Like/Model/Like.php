<?php
class Magedoc_Like_Model_Like extends Mage_Core_Model_Abstract
{
    public $productId;
    public $storeId;
    protected function _construct()
    {
        parent::_construct();
        $this->_init('like/like');
    }

    public function getLikeToProduct($productId, $storeId) {

        //$likes = Mage::getResourceModel("like/takelikescount")->getLikes($productId, $storeId);
        $likes = $this->getResource()->getLikes($productId, $storeId);
        return $likes;
    }
    /*
     * return store Id
     */
    public function getStoreId()
    {
        $store = Mage::app()->getStore()->getId();
        return $store;

    }
    /*
     * *return product Id
     */
    public function getProductId()
    {
        $productId = Mage::registry('current_product')->getId();
        return $productId;
    }




    public function updateLikeProduct($product_Id, $store_Id) {
        $likes = $this->getResource()->updateLikes($product_Id, $store_Id);
        return $likes;
    }
}