<?php

class IGN_Siteblocks_Model_Resource_Block_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct()
    {
        $this->_init('siteblocks/block');
    }
}