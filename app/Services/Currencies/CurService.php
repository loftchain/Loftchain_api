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
		$res1 = $client->request('GET', 'https://min-api.cryptocompare.com/data/pricemulti?fsyms=' . env('CURRENCIES') . '&tsyms=USD');
		$res2 = $client->request('GET', 'https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=' . env('CURRENCIES'));
		$res3 = $client->request('GET', 'https://min-api.cryptocompare.com/data/pricemulti?fsyms=' . env('CURRENCIES') . '&tsyms=ETH');

		$body1 = json_decode($res1->getBody());
		$body2 = json_decode($res2->getBody());
		$body3 = json_decode($res3->getBody());
		return [$body1, $body2, $body3];
	}

	public function cur_recompileAndStoreTx()
	{
		$db = [];
		$currencies = json_decode(json_encode($this->cur_get()), true);
		foreach ($currencies[0] as $k => $v) {
			$db[] = [
				'pair' => $k . '/USD',
				'price' => $v['USD'],
				'timestamp' => time()
			];
		}
		foreach ($currencies[1] as $k => $v) {
			$db[] = [
				'pair' => 'USD/' . $k,
				'price' => $v,
				'timestamp' => time()
			];
		}
		foreach ($currencies[2] as $k => $v) {
			if($k == 'BTC'){
				$db[] = [
					'pair' => $k . '/ETH',
					'price' => $v['ETH'],
					'timestamp' => time()
				];
			}
		}
	  for ($k = 0; $k < count($db); $k++) {
			  Currencies::create($db[$k]);
	  }
	  Log::info('Currencies stored');
	}

	public function cur_getCurFromDb()
	{
		$cur = DB::table('currencies')
			->orderBy('id', 'desc')
			->get();
		return $cur;

	}
}
