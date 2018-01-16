<?php

class Itransition_Insurance_Block_Adminhtml_Insurance extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_insurance';
        $this->_blockGroup = 'insurance';
        $this->_headerText = Mage::helper('insurance')->__('Insurance');
        $this->_addButtonLabel = Mage::helper('insurance')->__('Add New Insurance');
        parent::__construct();
    }

}