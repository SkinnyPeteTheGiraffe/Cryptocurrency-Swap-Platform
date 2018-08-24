<?php

namespace App\Http\Controllers;

use App\Coin;
use App\CoinInfo;
use App\SwapWallet;
use App\RPC\RpcClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Adds pair to the user's list given the correct post request
     *
     * @return \Illuminate\Http\Response
     */
    public function add_pair()
    {
        $id = request('pair_id');
        $address = request('destination_address');
        if($id) {
            $user = Auth::user();
            $swap_pairs = unserialize($user->swap_pairs);
            if(!$user->owns_swap_pair($id)) {
                $this->create_swap_wallet($user, $id, $address);
                $swap_pairs[] = $id;
                $user->swap_pairs = serialize($swap_pairs);
                $user->save();
            }
        }
        return redirect(route('home'));
    }

    private function create_swap_wallet($user, $id, $address) {
        SwapWallet::create([
            'user_id'           => $user->id,
            'swap_pair_id'      => $id,
            'active_address'    => $address
        ]);
    }

}
