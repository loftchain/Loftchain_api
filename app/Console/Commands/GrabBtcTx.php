<?php

namespace App\Console\Commands;

use App\Services\Transactions\BtcService;
use Illuminate\Console\Command;
use App\Models\Customers;


class GrabBtcTx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:btc';

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
	protected $btcService;

	public function __construct(BtcService $btcService)
	{
		$this->btcService = $btcService;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$customer = Customers::where('wallet_currency', 'BTC')->get();

		foreach ($customer as $c){
			$this->btcService->btc_recompileAndStoreTx($c->wallet);
		}
	}
}
