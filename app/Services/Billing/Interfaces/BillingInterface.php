<?php

namespace App\Services\Billing\Interfaces;

interface BillingInterface {
	/**
	 * @param array $chargeData ['amount', 'mobile_number']
	 * 
	 * @return array
	 */
	public function chargeCustomer($chargeData);
}