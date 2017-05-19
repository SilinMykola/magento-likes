<?php

class Magedoc_Like_Adminhtml_LikeController extends Mage_Adminhtml_Controller_Action

{
    public function indexAction()
    {
        $this->_title($this->__('Customer'))->_title($this->__('Magedoc Like'));
        $this->loadLayout();
        $this->_setActiveMenu('customer/customer');
        $this->_addContent($this->getLayout()->createBlock('adminhtml/store_switcher') ->setUseConfirm(false));
        $this->_addContent($this->getLayout()->createBlock('like/adminhtml_like_like'));
        $this->renderLayout();
        //die("admin");
    }

    public function exportLikeCsvAction()
    {
        $fileName = 'magedoc_like.csv';
        $grid = $this->getLayout()->createBlock('like/adminhtml_like_like_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportLikeExcelAction()
    {
        $fileName = 'magedoc_like.xml';
        $grid = $this->getLayout()->createBlock('like/adminhtml_like_like_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('like/adminhtml_like_like_grid')->toHtml()
        );
    }
}