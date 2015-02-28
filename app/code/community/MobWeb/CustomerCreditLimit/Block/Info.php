<?php
class MobWeb_CustomerCreditLimit_Block_Info extends Mage_Core_Block_Abstract
{
	protected function _toHtml()
	{

		// Get the list of currently blocked payment methods from the session
		$currentlyBlockedPaymentMethods = Mage::getSingleton('adminhtml/session')->getData(MobWeb_CustomerCreditLimit_Helper_Data::$currentlyBlockedPaymentMethodsSessionIdentifier);

		// If no payment methods are currently blocked, don't display anything
		if(!$currentlyBlockedPaymentMethods || !count($currentlyBlockedPaymentMethods)) {
			return '';
		}

		// If any payment methods are currently blocked, see if any static blocks exist for these payment methods,
		// and display them
		$html = '';
		foreach($currentlyBlockedPaymentMethods AS $paymentMethodCode) {
			$block = $this->getLayout()->createBlock('cms/block')->setBlockId('payment_method_information_' . $paymentMethodCode);

			// If this block exists, load its content
			if($block) {
				$html .= $block->toHtml();
			}
		}

		// Reset the list of blocked payment methods in the session, so that it can be recreated every time the payment informations are loaded
		Mage::getSingleton('adminhtml/session')->setData(MobWeb_CustomerCreditLimit_Helper_Data::$currentlyBlockedPaymentMethodsSessionIdentifier, '');

		// Return the HTML for the block
		return $html;
	}
}