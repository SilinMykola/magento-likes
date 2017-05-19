<?php
class Magedoc_Like_Model_Resource_Like_Collection extends  Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this-> _init('like/like');
    }

}