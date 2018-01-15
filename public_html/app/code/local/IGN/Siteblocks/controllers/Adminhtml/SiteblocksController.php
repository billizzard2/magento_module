<?php

class IGN_Siteblocks_Adminhtml_SiteblocksController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('siteblocks/adminhtml_siteblocks'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('block_id');
        Mage::register('siteblocks_block', Mage::getModel('siteblocks/block')->load($id));
        $blockObject = (array) Mage::getSingleton('adminhtml/session')->getBlockObject(true);
        if (count($blockObject)) {
            Mage::registry('siteblocks_block')->setData($blockObject);
        }
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('siteblocks/adminhtml_siteblocks_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $id = $this->getRequest()->getParam('block_id');
            $block = Mage::getModel('siteblocks/block')->load($id);
//        $block->setTitle($this->getRequest()->getParam('title'))
//            ->setContent($this->getRequest()->getParam('content'))
//            ->setBlockStatus($this->getRequest()->getParam('block_status'))
//            ->save();
            $block
                ->setData($this->getRequest()->getParams())
                ->setCreatedAt(Mage::app()->getLocale()->date())
                ->save();

            if (!$block->getId()) {
                Mage::getSingleton('adminhtml/session')->addError('Cannot save siteblock');
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setBlockObject($block->getData());
            // вроде это надо
            //$this->_redirect('*/*/');
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Siteblock was saved successful');
        $this->_redirect('*/*/'.$this->getRequest()->getParam('back', 'index'), array('block_id' => $block->getId()));
    }

    public function deleteAction()
    {
        $block = Mage::getModel('siteblocks/block')
            ->setId($this->getRequest()->getParam('block_id'))
            ->delete();

        if ($block->getId()) {
            Mage::getSingleton('adminhtml/session')->addSuccess('Siteblock deleted');
        }

        $this->_redirect('*/*/');
    }

    public function massStatusAction()
    {
        $statuses = $this->getRequest()->getParams();
        try {
            $blocks = Mage::getModel('siteblocks/block')
                ->getCollection()
                ->addFieldToFilter('block_id', array('in' => $statuses['massaction']));
            foreach($blocks as $block) {
                $block->setBlockStatus($statuses['block_status'])->save();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Statuses were updated');
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $blocks = $this->getRequest()->getParams();
        try {
            $blocks = Mage::getModel('siteblocks/block')
                ->getCollection()
                ->addFieldToFilter('block_id', array('in' => $blocks['massaction']));
            foreach($blocks as $block) {
                $block->delete();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Statusblock were deleted');
        $this->_redirect('*/*/');
    }

//    public function populateEntriesAction() {
//        for ($i=0;$i<10;$i++) {
//            $weblog2 = Mage::getModel('complexword/evablogpost');
//            $weblog2->setTitle('This is a test '.$i);
//            $weblog2->setContent('This is test content '.$i);
//            $weblog2->setDate(now());
//            $weblog2->save();
//        }
//
//        echo 'Done';
//    }
//
//    public function showCollectionAction() {
//        $weblog2 = Mage::getModel('complexword/evablogpost');
//        $entries = $weblog2->getCollection()
//            ->addAttributeToSelect('title')
//            ->addAttributeToSelect('content');
//        $entries->load();
//        foreach($entries as $entry)
//        {
//            // var_dump($entry->getData());
//            echo '<h2>' . $entry->getTitle() . '</h2>';
//            echo '<p>Date: ' . $entry->getDate() . '</p>';
//            echo '<p>' . $entry->getContent() . '</p>';
//        }
//        echo '</br>Done</br>';
//    }

}