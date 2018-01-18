<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.1.18
 * Time: 11.38
 */

class Itransition_Insurance_Model_Fee extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        parent::_construct();
        $this->_init('insurance/fee');
        //echo Mage::helper('siteblocks')->__('Siteblocks');
    }

    public static function canApply($address) {
        return true;
    }

    public static function getFee() {
        return 37;
    }

}