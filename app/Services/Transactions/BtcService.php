<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use App\Models\Transactions;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BtcService
{

	protected function btc_numberOfInputTransactions($btc_wallet)
	{
		$client = new Client();
		$res = $client->request('GET', 'https://chain.so/api/v2/address/BTC/' . $btc_wallet); //TODO: Проверять время от времения правильное кол-во транзакций.
		$body = json_decode($res->getBody());
		return $body->data->total_txs;
	}

	protected function btc_getTx($btc_wallet, $latest_tx)
	{
		$client = new Client();
		$res = $client->request('GET', 'https://block.io/api/v2/get_transactions/?api_key=' . env('BLOCKIO_API_BTC') . '&type=received&addresses=' . $btc_wallet . '&before_tx' . $latest_tx);
		$body = json_decode($res->getBody());
		return $body->data->txs;
	}

	public function btc_recompileAndStoreTx($btc_wallet)
	{
		$db = [];
		$tx_num = $this->btc_numberOfInputTransactions($btc_wallet);
		$iterator = (int)ceil($tx_num / 25); // Сколько раз нужно собрать по 25 транзакций. Транзакции выдаются только по 25 штук, при текущем API.
		$latest_tx = '';
		$newTx = '';
		$customer = Customers::where('wallet', $btc_wallet)->first();

		if (!$customer) {
			return response()->json(['response' => 'customer with such wallet does not exist']);
		}

		for ($j = 0; $j < $iterator; $j++) {
			$transactions = $this->btc_getTx($btc_wallet, $latest_tx);
			for ($i = 0; $i < count($transactions); $i++) {
				$date = gmdate("Y-m-d H:i:s", $transactions[$i]->time);
				if ($newTx != $transactions[$i]->txid) {
					$db[] = [
						'txId' => $transactions[$i]->txid,
						'customer_id' => $customer['customer_id'],
						'currency' => $customer['wallet_currency'],
						'from' => $transactions[$i]->senders[0],
						'amount' => $transactions[$i]->amounts_received[0]->amount,
						'date' => $date,
						'status' => $transactions[$i]->confidence == 1 ? 'true' : 'false',
					];
				}
				$newTx = $transactions[$i]->txid;
			}
			$latest_tx = '=' . $transactions[count($transactions) - 1]->txid;
		}

		for ($k = 0; $k < count($db); $k++) {
			if (!Transactions::where('txId', '=', $db[$k]['txId'])->exists()) {
				Transactions::create($db[$k]);
			}
		}
		return $db;
	}

	public function btc_getTxFromDb($btc_wallet)
	{
		$customer = Customers::where('wallet', $btc_wallet)->first();
    $txs = Transactions::where('customer_id', $customer['customer_id'])->where('currency', 'BTC')->orderBy('date', 'desc')->get();

    if (!$customer) {
			return response()->json(['response' => 'Customer with such wallet does not exist']);
		}

    if (!$txs) {
      return response()->json(['response' => 'This address does not yet have any transactions']);
    }

		return $txs;

	}

	public function btc_cronProcess($btc_wallet)
	{


	}


}

//TODO: Крон