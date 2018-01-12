<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.1.18
 * Time: 11.45
 */

class Magentotutorial_Complexword_Model_Resource_Evablogpost extends Mage_Eav_Model_Entity_Abstract
{
    protected function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('complexword_evablogpost');
        $this->setConnection(
            $resource->getConnection('complexword_read'),
            $resource->getConnection('complexword_write')
        );
    }
}