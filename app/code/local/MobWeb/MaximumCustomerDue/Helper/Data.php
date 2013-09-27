<?php

class MobWeb_MaximumCustomerDue_Helper_Data extends Mage_Core_Helper_Abstract {

	/*
	 *
	 * This function checks if the payment method is available. If it is, it
	 * checks if the total customer order amount due is higher than the maximum
	 * set by the admin in the configuration. If it is, it checks if the
	 * current payment method should be blocked.
	 *
	 */
	public static function isPaymentMethodBlocked($checkResult, $currentPaymentMethodCode)
	{
		// Check if the payment method is available and if the customer
		// is logged in
		if($checkResult->isAvailable && Mage::getSingleton('customer/session')->isLoggedIn()) {
		    // Check if the currently processing payment method is set to be
		    // blocked at a certain total customer due
		    $blockedPaymentMethods = explode(',', Mage::getStoreConfig('maximumcustomerdue/settings/blocked_payment_methods'));

		    // Only continue the check if the current payment method is indeed
		    // blocked
		    if(in_array($currentPaymentMethodCode, $blockedPaymentMethods)) {
		        // Get a reference to the customer
		        $customer = Mage::getSingleton('customer/session')->getCustomer();

		        // Get all of the customer's orders
		        $orders =   Mage::getModel('sales/order')
		                    ->getCollection()
		                    ->addFieldToFilter('customer_id', $customer->getId())
		                    ->addAttributeToSelect('base_grand_total')
		                    ->addAttributeToSelect('base_total_paid');

		        // Loop through all the orders and add up the total due of
		        // all the orders
		        $orders = $orders->toArray();
		        $totalDue = 0;
		        foreach($orders['items'] AS $order) {
		        	Mage::log(print_r($order, true), NULL, 'mobweb.txt');
		            $orderDue = $order['base_grand_total']-$order['base_total_paid'];
		            $totalDue += $orderDue;
		        }

		        // Check if the total due is greater than what the admin set as
		        // the maximum total due per customer
		        $maximumCustomerDue = (int) Mage::getStoreConfig('maximumcustomerdue/settings/maximum_customer_due');
		        if($totalDue > $maximumCustomerDue) {
		            return false;
		        }
		    }
		}

		// Otherwise just use the original result to determine if the payment
		// method is available
		return $checkResult->isAvailable;
	}
}