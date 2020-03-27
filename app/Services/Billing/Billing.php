<?php

namespace App\Services\Billing;

use Illuminate\Support\Str;
use App\Services\Billing\Interfaces\BillingInterface;
use App\Services\Billing\Drivers\Mock\MockBiller;

class Billing implements BillingInterface {
	/**
	 * The array of created "drivers".
	 *
	 * @var array
	 */
	protected $drivers = [];
	protected $driver;

	public function __construct($driver = null)
	{
		$this->driver = $driver;
	}

	/**
	 * @param array $chargeData ['amount', 'mobile_number']
	 * 
	 * @return array
	 */
	public function chargeCustomer($chargeData)
	{
		return $this->driver()->chargeCustomer($chargeData);
	}
	/**
	 * DRIVERS
	 */

	/**
	 * Create Instance of Test Driver
	 *
	 * @return App\Services\Billing\Interfaces\BillingInterface
	 */
	protected function createMockDriver()
	{
		return new MockBiller();
	}

	protected function getDefaultDriver()
	{
		return 'mock';
	}
	/**
	 * END OF DRIVERS
	 *
	 */
	/**
	 * Get a driver instance.
	 *
	 * @param  string  $driver
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function driver()
	{
		$driver = $this->driver ?: $this->getDefaultDriver();

		if (is_null($driver)) {
			throw new \InvalidArgumentException(sprintf(
				'Unable to resolve NULL Billing driver for [%s].', static::class
			));
		}

		if (! isset($this->drivers[$driver])) {
			$this->drivers[$driver] = $this->createDriver($driver);
		}

		return $this->drivers[$driver];
	}

	/**
	 * Create a new driver instance.
	 *
	 * @param  string  $driver
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function createDriver($driver)
	{

		$method = 'create' . Str::studly($driver) . 'Driver';

		if (method_exists($this, $method)) {
			return $this->$method();
		}

		throw new \InvalidArgumentException("Billing Driver [$driver] not supported.");
	}

}