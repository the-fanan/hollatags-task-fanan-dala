<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Billing\Drivers\Mock\MockBiller;

class MockBillerDriverTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInvalidBillingDetailsRejected()
    {
        $biller = new MockBiller;
        $response = $biller->chargeCustomer([]);
        $this->assertEquals($response->getData()->status, 'error');
    }

    public function testValidBillingDetailsSucceeded()
    {
        $biller = new MockBiller;
        $response = $biller->chargeCustomer(['mobile_number' => '+193349847384', 'amount' => 500000]);
        $this->assertEquals($response->getData()->status, 'success');
        $this->assertEquals($response->getData()->data->amount, 500000);
    }
}
