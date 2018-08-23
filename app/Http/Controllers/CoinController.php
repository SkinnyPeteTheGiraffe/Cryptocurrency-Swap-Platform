<?php

namespace App\Http\Controllers;

use App\Coin;
use App\CoinInfo;
use App\RPC\RpcClient;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    private function get_coins_values()
    {
        $active_coins = Coin::where('active_project', true)->get();
        $active_coins_infos = [];
        $rpc_clients = [];
        foreach ($active_coins as $coin) {
            $active_coins_infos[] = CoinInfo::where('id', $coin->id)->first();
            $rpc_clients[$coin->ticker] = new RpcClient($coin->rpc_user, $coin->rpc_password, $coin->host, $coin->port);
        }
        return [$active_coins, $active_coins_infos, $rpc_clients];
    }

    private function get_coin_values($id)
    {
        $coin = Coin::where('ticker', $id)->first();
        $active_coin_info = CoinInfo::where('id', $coin->id)->first();
        $rpc_client =  new RpcClient($coin->rpc_user, $coin->rpc_password, $coin->host, $coin->port);
        return [$coin, $active_coin_info, $rpc_client];
    }
    /**
     * Show the application supported coins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = $this->get_coins_values();
        $active_coins = $values[0];
        $active_coins_infos = $values[1];
        $rpc_clients = $values[2];
        return view('supported')
            ->with('active_coins', $active_coins)
            ->with('active_coins_infos', $active_coins_infos)
            ->with('rpc_clients', $rpc_clients);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info($id)
    {
        $values = $this->get_coin_values($id);
        $coin = $values[0];
        $active_coin_info = $values[1];
        $rpc_client = $values[2];
        return view('supported-coin')
            ->with('coin', $coin)
            ->with('info', $active_coin_info)
            ->with('rpc_client', $rpc_client);
    }
}
