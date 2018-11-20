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
		$client = new Client(['headers' => ['X-CoinAPI-Key' => 'FD93956C-E7F6-4564-A60B-A320FE7BE2F3']]);
		$res1 = $client->request('GET', 'https://rest.coinapi.io/v1/exchangerate/BTC/USD');
		$res2 = $client->request('GET', 'https://rest.coinapi.io/v1/exchangerate/ETH/USD');
		$res3 = $client->request('GET', 'https://rest.coinapi.io/v1/exchangerate/BTC/ETH');

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
				'pair' => $cur['asset_id_base']. '/' . $cur['asset_id_quote'],
				'price' => $cur['rate'],
				'timestamp' => strtotime($cur['time'])
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
