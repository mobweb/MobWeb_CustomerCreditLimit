<?php

class MobWeb_CustomerCreditLimit_Helper_Data extends Mage_Core_Helper_Abstract {

	/*
	 *
	 * This function checks if the payment method is available. If it is, it
	 * checks if the total customer order amount due is higher than the maximum
	 * set by the admin in the configuration. If it is, it checks if the
	 * current payment method should be blocked.
	 *
	 */
	public static function isPaymentMethodBlocked($checkResult, $currentPaymentMethodCode, $quote)
	{
		$logFile = 'mobweb.customercreditlimit.log';

		Mage::log(sprintf('Checking if payment method should be blocked: %s', $currentPaymentMethodCode), NULL, $logFile);

		// Check if the payment method is available and if the customer
		// is logged in
		if($checkResult->isAvailable && Mage::getSingleton('customer/session')->isLoggedIn()) {
		    // Check if the currently processing payment method is set to be
		    // blocked at a certain total customer due
		    $blockedPaymentMethods = explode(',', Mage::getStoreConfig('customercreditlimit/settings/blocked_payment_methods'));

		    // Only continue the check if the current payment method is indeed
		    // blocked
		    if(in_array($currentPaymentMethodCode, $blockedPaymentMethods)) {
		    	Mage::log(sprintf('Payment method is in list of blocked payment methods (%s).', implode(',', $blockedPaymentMethods)), NULL, $logFile);

		        // Get a reference to the customer
		        $customer = Mage::getSingleton('customer/session')->getCustomer();

		        // Get all of the customer's non-canceled or completed orders
		        $orders =   Mage::getModel('sales/order')
		                    ->getCollection()
		                    ->addFieldToFilter('customer_id', $customer->getId())
		                    ->addFieldToFilter('status', array('nin' => array('canceled', 'complete')))
		                    ->addAttributeToSelect('base_grand_total')
		                    ->addAttributeToSelect('base_total_paid');

		        // Loop through all the orders and add up the total due of
		        // all the orders
		        $orders = $orders->toArray();
		        $totalDue = 0;
		        foreach($orders['items'] AS $order) {
		            $orderDue = $order['base_grand_total']-$order['base_total_paid'];
		            $totalDue += $orderDue;
		        }

		        // Add the total amount of the current order to the total due.
		        // Example: If the customer has open invoices for 500$ total
		        // and the admin set a customer credit limit of 750$, if the 
		        // current order exceeds 250$ we have to block the blocked
		        // payment methods for this order already
		        $orderTotal = $quote ? $quote->getGrandTotal() : 0;
		        $totalDue += $orderTotal;

		        // Check if the total due is greater than what the admin set as
		        // the maximum total due per customer
		        $maximumCustomerDue = (int) Mage::getStoreConfig('customercreditlimit/settings/maximum_customer_due');
		        if($totalDue > $maximumCustomerDue) {
		        	Mage::log(sprintf('Current customer credit (%s) bigger than configured credit limit (%s), blocking payment method.', $totalDue, $maximumCustomerDue), NULL, $logFile);
		            return false;
		        } else {
		        	Mage::log(sprintf('Current customer credit (%s) is smaller than configured credit limit (%s), not blocking payment method.', $totalDue, $maximumCustomerDue), NULL, $logFile);
		        }
		    } else {
		    	Mage::log('Not blocking payment method. Not in configured list of blocked payment methods.', NULL, $logFile);
		    }
		} else {
			Mage::log('Unable to check if payment method should be blocked. Either its not available anyway or the customer isnt logged in', NULL, $logFile);
		}

		// Otherwise just use the original result to determine if the payment
		// method is available
		return $checkResult->isAvailable;
	}
}