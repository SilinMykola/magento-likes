<?php

class Magedoc_Like_Model_Resource_Like extends Magedoc_Like_Model_Resource_Abstract
{
    protected $tableName;
    public function _construct()
    {
        $this->_init('like/product_like_aggregate', 'id');
    }
    /*
     * return like_count from table
     *
     */
    public function getLikes($productId, $storeId)
    {


        $sql = $this->getReadConnection()
        ->select('like_count')
        ->from($this->getMainTable())
        ->where('product_id=?', $productId)
        ->where('store_id=?', $storeId);

        $likes = $this->getReadConnection()
            ->fetchRow($sql);
        if ($likes) {
            return $likes['like_count'];
        } else {
            return 0;
        }

    }

    public function getLikesRecord($productId, $storeId)
    {


        $sql = $this->getReadConnection()
            ->select('like_count')
            ->from($this->getMainTable())
            ->where('product_id=?', $productId)
            ->where('store_id=?', $storeId);

        $likes = $this->getReadConnection()
            ->fetchRow($sql);
        if ($likes) {
            return $likes;
        } else {
            return 0;
        }

    }

    public function updateLikes($productId, $storeId)
    {
        $sql = $this->getReadConnection()
            ->select('like_count')
            ->from($this->getMainTable())
            ->where('product_id=?', $productId)
            ->where('store_id=?', $storeId);
        $old_likes =  $this->getReadConnection()
            ->fetchRow($sql);
        if ($old_likes) {
            $new_likes = array('id' => $old_likes['id'], 'product_id' => $old_likes['product_id'], 'store_id' => $old_likes['store_id'], 'like_count' => $old_likes['like_count']+1);
//            $update = $this->getReadConnection()
//                ->update($this->getMainTable(),$new_likes);
//            Mage::getModel('magedoc/like')
//                ->setData($new_likes)
//                ->save();
            return $new_likes['like_count'];
        } else {
            return 0;
        }

    }


}