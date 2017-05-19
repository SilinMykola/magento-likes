<?php

class Magedoc_Like_Model_Options {
    /**
     * Provide available options as a value/label array
     *
     * @return array
     */
    public function toOptionArray() {
        $category_list = [];
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('level', array('gteq' => 2))
            ->addIsActiveFilter()
            ->addAttributeToSelect(array('name', 'entity_id', 'level'))
            ->setOrder('path');
        foreach ($categories as $category) {
            $label = $category['name'];
            for($i=1; $i<$category['level']; $i++) {
                $label = '--'.$label;
            }
            $category_list[] = array('value' => $category->getId(), 'label' => $label);
        }
        return $category_list;

    }
}