<?php

namespace App\Console\Commands;

use App\Models\Customers;
use App\Services\Transactions\EthService;
use Illuminate\Console\Command;

class GrabEthTx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:eth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
	protected $ethService;

	public function __construct(EthService $ethService)
    {
	    $this->ethService = $ethService;
	    parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$customer = Customers::where('wallet_currency', 'ETH')->get();

    	foreach ($customer as $c){
		    $this->ethService->eth_recompileAndStoreTx($c->wallet);
	    }

    }
}
