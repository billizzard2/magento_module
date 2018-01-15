<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.1.18
 * Time: 11.38
 */

class IGN_Siteblocks_Model_Block extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        parent::_construct();
        $this->_init('siteblocks/block');
        //echo Mage::helper('siteblocks')->__('Siteblocks');
    }
}