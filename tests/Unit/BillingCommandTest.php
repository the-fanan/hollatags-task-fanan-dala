<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Console\Commands\BillingCommand;
use App\Jobs\BillUser as BillUserJob;

class BillingCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testJobsAreDispatched()
    {
        Queue::fake();
        $command = new BillingCommand;
        Queue::assertNothingPushed();
        $command->handle();
        Queue::assertPushed(BillUserJob::class, (int)env('SEED_USERS_NUMBER'));
    }
}
