<?php

namespace App\Services\SmartContract;

use GuzzleHttp\Client;

class ScService
{


	public function sc_get()
	{
		$client = new Client();
		$res = $client->request('GET', 'https://api.etherscan.io/api?module=stats&action=tokensupply&contractaddress='.env('MAIN_ETH').'&apikey='.env('ETHERSCAN_API_KEY'));
		$body = json_decode($res->getBody(), true);
		return ['tokenSupply' => $body['result']];
	}

	public function btc_cronProcess($btc_wallet)
	{


	}


}
