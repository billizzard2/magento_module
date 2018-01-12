<?php
$installer = $this;
$installer->startSetup();
$installer->addEntityType('complexword_evablogpost',
    array(
        'entity_model' => 'complexword/evablogpost',
        'table' => 'complexword/evablogpost'
    ));

$installer->createEntityTables(
    $this->getTable('complexword/evablogpost')
);

$this->addAttribute('complexword_evablogpost', 'title', array(
    //the EAV attribute type, NOT a MySQL varchar
    'type'              => 'varchar',
    'label'             => 'Title',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => true,
    'user_defined'      => true,
    'default'           => '',
    'unique'            => false,
));
$this->addAttribute('complexword_evablogpost', 'content', array(
    'type'              => 'text',
    'label'             => 'Content',
    'input'             => 'textarea',
));
$this->addAttribute('complexword_evablogpost', 'date', array(
    'type'              => 'datetime',
    'label'             => 'Post Date',
    'input'             => 'datetime',
    'required'          => false,
));


$installer->endSetup();