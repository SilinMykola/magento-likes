<?php
class Magedoc_Like_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {

    }
    protected function _getLoadSelect($field, $value, $object)
    {
        if (is_array($value)) {
            $select = $this->_getReadAdapter()->select()
                ->from($this->getMainTable());
            foreach ($value as $field => $count) {
                $field = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $field));
                $select->where($field . '=?', $count);
            }
            return $select;
        } else {
          return parent::_getloadSelect($field, $value, $object);
        }
    }
}