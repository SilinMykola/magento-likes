<?php
class Magedoc_Like_Block_Widget extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
//    protected function _toHtml()
//    {
//        $html = '';
//        $selected_category = $this->getData('my_categories');
//        $quantity = $this->getData('quantity');
//        $title = $this->getData('likes_title');
//        $html .= $title;
//        $html .= $quantity;
//        $html .= $selected_category;
//
//        return $html;
//    }

    public function getPopularCategory()
    {
        $selected_category = $this->getData('my_categories');
        $categories = explode(',', $selected_category);
        return $categories;
    }

    public function getProducts()
    {
        $store = Mage::app()->getStore()->getId();
        if (Mage::getModel('catalog/layer')->getCurrentCategory()) {
            $current_category = Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
        }

        $productCollection = Mage::getModel('catalog/product')
                            ->getCollection()
                            ->joinField('category_id','catalog/category_product','category_id','product_id=entity_id',null,'left')
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter('type_id', array('eq' => 'simple'))
                            ->joinField('likes','like/product_like_aggregate','like_count', 'product_id = entity_id',array('store_id' => $store),'right')
                            ->addAttributeToFilter('likes', array('gt' => 0))
//                            ->addAttributeToFilter('store_id', array('eq' => $store))
                            ->groupByAttribute('entity_id');
                            //->reset(Zend_Db_Select::GROUP);
                            //->getSelect()->group('e.entity_id');
                            //->addAttributeToFilter('url_path', array('like' => 'apparel%'));
//        echo $productCollection->getSelect();
//        die();
        $categories = $this->getPopularCategory();
        if ($categories) {
            $productCollection->addAttributeToFilter('category_id', array('in' => $categories));
            if (empty($productCollection->getallIds())) {
                $productCollection->getSelect()->reset(Zend_Db_Select::WHERE);
            }
        } elseif ($current_category) {
                $productCollection->addAttributeToFilter('category_id', array('in' => $current_category));
        }

        $quantity = $this->getData('quantity');
        if ($quantity) {
            $productCollection->setPageSize($quantity);
        }
        $productCollection->setOrder('like_count', 'desc');

        //var_dump($productCollection->getSize());
        //var_dump(count($productCollection));
        return $productCollection;
    }
}