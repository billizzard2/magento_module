<?php

class IGN_Siteblocks_Test1Controller extends Mage_Core_Controller_Front_Action
{
    public function renamedAction() {

        $field1 = Mage::getStoreConfig('siteblocks/settings/field1');
        $text = Mage::getStoreConfig('siteblocks/settings/raw_text');
        var_dump($field1);
        var_dump($text);
        Mage::app()->getConfig()->saveConfig('siteblocks/settings/raw_text', $text . '1');
        // при удалении из системы
        //Mage::app()->getConfig()->deleteConfig();
        echo Mage::helper('siteblocks')->__('Siteblocks');
        die('dfdf');
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