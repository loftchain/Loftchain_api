<?php

namespace App\Services\Currencies;

use GuzzleHttp\Client;
use App\Models\Currencies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurService
{


	public function cur_get()
	{
		$client = new Client();
		$res1 = $client->request('GET', 'https://api.cryptonator.com/api/ticker/btc-usd');
		$res2 = $client->request('GET', 'https://api.cryptonator.com/api/ticker/eth-usd');
		$res3 = $client->request('GET', 'https://api.cryptonator.com/api/ticker/btc-eth');

		$body1 = json_decode($res1->getBody());
		$body2 = json_decode($res2->getBody());
		$body3 = json_decode($res3->getBody());
		return [$body1, $body2, $body3];
	}

	public function cur_recompileAndStoreTx()
	{
		$db = [];
		$currencies = json_decode(json_encode($this->cur_get()), true);
		foreach ($currencies as $cur) {
			$db[] = [
				'pair' => $cur['ticker']['base']. '/' . $cur['ticker']['target'],
				'price' => $cur['ticker']['price'],
				'timestamp' => $cur['timestamp']
			];
		}
	  for ($k = 0; $k < count($db); $k++) {
			  Currencies::create($db[$k]);
	  }
	}

	public function cur_getCurFromDb()
	{
		$cur = DB::table('currencies')
			->orderBy('id', 'desc')
			->get();
		return $cur;

	}
}
