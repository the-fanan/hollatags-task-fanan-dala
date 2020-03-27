<?php

namespace App\Services\Billing\Drivers\Mock;

use App\Services\Billing\Interfaces\BillingInterface;
use Illuminate\Support\Facades\Validator;

class MockBiller implements BillingInterface {
	/**
	 * @param array $chargeData ['amount', 'mobile_number']
	 * 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function chargeCustomer($chargeData)
	{
		$validator = Validator::make($chargeData, [
			'amount' => ['required', 'numeric'],
			'mobile_number' => ['required', 'string', 'max:100',],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'errors' => $validator->errors(),
			],400);
		}

		sleep(1.5);

		return response()->json([
			'status' => 'success',
			'data' => ['amount' => $chargeData['amount']],
		],200);

	}
}