<?php

class MobWeb_CustomerCreditLimit_Model_Observer
{
	public function paymentMethodIsActive($observer)
	{
		// Get the data from the observer
		$checkResult = $observer->getResult();
		$methodInstance = $observer->getMethodInstance();
		$quote = $observer->getQuote();

		// Update the result according to our credit limit check
		$checkResult->isAvailable = MobWeb_CustomerCreditLimit_Helper_Data::isPaymentMethodBlocked($checkResult, $methodInstance->getCode(), $quote);
	}
}