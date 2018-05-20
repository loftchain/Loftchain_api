<?php

namespace App\Console\Commands;

use App\Services\Currencies\CurService;
use Illuminate\Console\Command;

class GrabCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:currencies';

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
	protected $curService;

	public function __construct(CurService $curService)
	{
		$this->curService = $curService;
		parent::__construct();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $this->curService->cur_recompileAndStoreTx();
    }
}
