<?php
class Magedoc_Like_Model_Observer
{
    public function addLikesToCollection(Varien_Event_Observer $observer)
    {
    $data = $observer->getEvent()->getCollection();
    // TODO добавить проверку чтобы на странице при формировании колекции продуктов на странице обсервер запускался один раз если колекция формируется один раз
    $alias = 'like_count';
    $table = 'like/product_like_aggregate';
    $field = 'like_count';
    $bind = 'product_id=entity_id';
    $cond = array('store_id' => Mage::app()->getStore()->getId());
    $joinType = 'left';
    $data->joinField($alias, $table, $field, $bind, $cond, $joinType);
    }
}