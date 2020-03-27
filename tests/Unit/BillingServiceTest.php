<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Billing\Billing;

class BillingServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBillingServiceWorksWithMockDriver()
    {
        $biller = new Billing('mock');
        $response = $biller->chargeCustomer(['mobile_number' => '+193349847384', 'amount' => 500000]);
        $this->assertEquals($response['status'], 'success');
        $this->assertEquals($response['data']['amount'], 500000);
    }
}
