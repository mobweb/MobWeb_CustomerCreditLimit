<?php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$setup->addAttribute('customer', 'credit_limit', array(
	'type' => 'int',
	'input' => 'text',
	'label' => 'Credit Limit',
	'global' => 1,
	'visible' => 1,
	'required' => 0,
	'visible_on_front' => 0,
));

$setup->addAttributeToGroup(
	$entityTypeId,
	$attributeSetId,
	$attributeGroupId,
	'credit_limit',
	'100'
);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'credit_limit');
$oAttribute->setData('used_in_forms', array('adminhtml_customer')); 
$oAttribute->save();

$setup->endSetup();