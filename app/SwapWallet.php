<?php

namespace App;

use App\SwapPair;
use Illuminate\Database\Eloquent\Model;

class SwapWallet extends Model
{
    private $swap_pair;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'swap_pair_id', 'active_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'swap_pair_id', 'active_address',
    ];

    public function get_swap_pair() {
        if(!$this->swap_pair) {
            $this->swap_pair = SwapPair::find($this->swap_pair_id);
        }
        return $this->swap_pair;
    }

    public function is_active_wallet_valid() {
        $swap_pair = $this->get_swap_pair();
        if($swap_pair) {
            $coin = Coin::find($swap_pair->active_id);
            if ($coin) {
                $response = $coin->get_rpc_client()->validateaddress($this->active_address);
                if (key_exists('isvalid', $response) && $response['isvalid']) {
                    return True;
                }
            }
        }
        return false;
    }

    public function get_swaps() {
        $swap_wallets = Swap::where('wallet_id', $this->id)->get();
        return $swap_wallets;
    }
}
