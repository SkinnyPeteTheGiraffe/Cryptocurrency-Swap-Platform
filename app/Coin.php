<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SwapPair;
use App\RPC\RpcClient;

class Coin extends Model
{
    private $rpc_client;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ticker', 'host', 'port', 'rpc_user', 'rpc_password', 'active_project', 'supported_swaps', 'fee',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'host', 'port', 'rpc_user', 'rpc_password', 'supported_swaps',
    ];

    public function get_swap_pairs() {
        if($this->active_project) {
            $pairs = SwapPair::where('active_id', $this->id)->orderBy('created_at', 'desc')->get();
            return $pairs;
        }
        return [];
    }

    public function get_rpc_client() {
        if(!$this->rpc_client || !$this->rpc_client->is_connected()) {
            $this->rpc_client =  new RpcClient($this->rpc_user, $this->rpc_password, $this->host, $this->port);
        }
        return $this->rpc_client;
    }

    public function get_coin_info() {
        return CoinInfo::where('coin_id', $this->id)->first();
    }
}
