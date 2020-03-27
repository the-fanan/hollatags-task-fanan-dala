<?php

namespace app\Service\Billing\Interfaces;

interface BillingInterface {
	/**
	 * @param array $chargeData ['amount', 'mobile_number']
	 * 
	 * @return array
	 */
	public function chargeCustomer($chargeData);
}