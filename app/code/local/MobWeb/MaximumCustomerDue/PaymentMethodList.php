<?php

class MobWeb_MaximumCustomerDue_PaymentMethodList
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'Courier', 'label'=>Mage::helper('adminhtml')->__('Courier')),
            array('value' => 'Courier-Bold', 'label'=>Mage::helper('adminhtml')->__('Courier-Bold')),
            array('value' => 'Courier-Oblique', 'label'=>Mage::helper('adminhtml')->__('Courier-Oblique')),
            array('value' => 'Courier-BoldOblique', 'label'=>Mage::helper('adminhtml')->__('Courier-BoldOblique'))
        );
    }
}