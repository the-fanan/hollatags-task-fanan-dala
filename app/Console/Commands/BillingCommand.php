<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\BillUser as BillUserJob;

class BillingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hollatags:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bill All Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = DB::table('users')->select('amount_to_bill', 'mobile_number')->get();
        foreach ($users as $user) {
            BillUserJob::dispatch($user);
        }
    }
}
