<?php

class Magedoc_Like_Block_Adminhtml_Like_Like extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'like';
        $this->_controller = 'adminhtml_like_like';
        $this->_headerText = Mage::helper('like')->__('Magedoc - Like');

        parent::__construct();
        $this->_removeButton('add');
    }

}
