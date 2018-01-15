<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$installer->run("
    CREATE TABLE `{$installer->getTable('siteblocks/block')}` (
      `block_id` int(11) NOT NULL auto_increment,
      `title` varchar(500) NOT NULL,
      `content` text NOT NULL,
      `block_status` tinyint(4) NOT NULL,
      `created_at` datetime NOT NULL,
      PRIMARY KEY  (`block_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

//$installer->run("
//    CREATE TABLE `{$installer->getTable('siteblocks/block')}` (
//      `block_id` int(11) NOT NULL auto_increment,
//      `title` varchar(500) NOT NULL,
//      `content` text NOT NULL,
//      `block_status` tinyint(4) NOT NULL,
//      `created_at` datetime NOT NULL,
//      PRIMARY KEY  (`block_id`)
//    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//    INSERT INTO `{$installer->getTable('weblog/blogpost')}` VALUES (1,'My New Title','This is a blog post','2009-07-01 00:00:00','2009-07-02 23:12:30');
//");
$installer->endSetup();