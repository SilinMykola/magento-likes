<?php

class Magedoc_Like_Block_Adminhtml_Like_Like_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('magedoc_like_grid');
//        $this->setDefaultSort('id');
//        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {

        $stor = $this->getRequest()->getParam('store', 0);
        $collection = Mage::getModel('like/adding')->getCollection();
        if ($stor) {
            $collection->addFieldToFilter('main_table.store_id', array('eq' => $stor));
        }
        $collection->addCustomerFullName();
        $collection->addProductName();

//        $collection->addFilterToMap('fullname', 'fullname');
//        echo($collection->getSelect());
//        die();

//        var_dump($collection->getColumnValues('fullname'));
//        die();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }



    protected function _prepareColumns()
    {
        $helper = Mage::helper('like');

        $this->addColumn('id', array(
            'header' => $helper->__('Id'),
            'index'  => 'id',
            'width' => '50px',
            'align' => 'center'
        ));

        $this->addColumn('customer_id', array(
            'header' => $helper->__('Customer Id'),
            'index'  => 'customer_id',
            'width' => '50px',
            'align' => 'center'
        ));

        $store = [];
        $allStores = Mage::app()->getStores();
        foreach ($allStores as $_eachStoreId => $val)
        {
            //$store[] = Mage::app()->getStore($_eachStoreId)->getName(); //Store Name
            $store[] = Mage::app()->getStore($_eachStoreId)->getId(); // Store Id
        }

        $this->addColumn('store_id', array(
            'header' => $helper->__('Store Id'),
            'index'  => 'store_id',
            'width' => '50px',
            'type' => 'options',
            'options'   => $store,
            'align' => 'center',
            'filter_index' => 'main_table.store_id'
        ));

        $this->addColumn('product_id', array(
            'header' => $helper->__('Product Id'),
            'index'  => 'product_id',
            'width' => '50px',
            'align' => 'center',

        ));

        $this->addColumn('product_name', array(
            'header' => $helper->__('Product Name'),
            'index'  => 'product_name',
            'filter_index' => 'cpev.value'
        ));

        $this->addColumn('customer_ip', array(
            'header' => $helper->__('Customer Ip'),
            'index'  => 'customer_ip',
            'filter_index' => 'main_table.customer_ip'
        ));

        $this->addColumn('created_at', array(
            'header' => $helper->__('Created At'),
            'type'   => 'datetime',
            'index'  => 'created_at',
            'filter_index' => 'main_table.created_at'
        ));
        $this->addColumn('fullname', array(
            'header'    => Mage::helper('sales')->__('Customer Name'),
            'index' => 'fullname',
            //'fiter_index' => 'fullname'
            'filter_condition_callback' => array($this, 'filterName')
            //TODO: make filter by fullname
            //'filter_condition_callback' => array($this, 'filterFullName')
        ));

        $this->addExportType('*/*/exportLikeCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportLikeExcel', $helper->__('Excel XML'));


        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/*/grid', array('_current'=>true));
    }

    public function filterName($collection, $column)
    {
        $value = $column->getFilter()->getValue();

        if (!isset($value)) {
            return;
        } else {
            $search = array_map('trim', explode(' ', $value));
            foreach ($search as $word) {
                $collection->addFieldToFilter(array('ce1.value', 'ce2.value'), array(array('like' => '%' . $word . '%'), array('like' => '%' . $word . '%')));
            }
            return $collection;
        }
    }

    public function filterFullName($collection, $column)
    {

        $value = $column->getFilter()->getValue();
        if (!isset($value)) {
            return;
        } else {
//            $collection->addFieldToFilter('fullname', array('like' => '%' . $value . '%'));
            $collection->getSelect()->having("`fullname` like `%$value%`");
//            echo($collection->getSelect());
//            die();
        }
        return $collection;
    }
}
