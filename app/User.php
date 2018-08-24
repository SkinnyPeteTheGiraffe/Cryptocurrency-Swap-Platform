<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Coin;
use App\SwapPair;
use App\SwapWallet;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deposit_addresses'
    ];

    public function get_dead_wallet_address($coin_id) {
        $coin = Coin::find($coin_id);
        if($coin) {
            $rpc_client = $coin->get_rpc_client();
            if($rpc_client && $rpc_client->is_connected()) {
                $wallet_address = $rpc_client->getaccountaddress($this->email);
                if($wallet_address && is_string($wallet_address)) {
                    return $wallet_address;
                }
            }
        }
        return "Error retrieving deposit address!";
    }

    public function get_active_wallet_address($pair_id) {
        $swap_wallets = $this->get_swap_wallets();
        if(count($swap_wallets) > 0) {
            foreach ($swap_wallets as $pair) {
                if($pair->swap_pair_id == $pair_id) {
                    return $pair->active_address;
                }
            }
        }
        return "Error retrieving destination address!";
    }

    public function owns_swap_pair($id) {
        $swap_pairs = unserialize($this->swap_pairs);
        $included = False;
        if(count($swap_pairs) > 0) {
            foreach ($swap_pairs as $pair) {
                if($pair == $id) {
                    $included = True;
                    break;
                }
            }
        }
        return$included;
    }

    public function get_swap_pairs() {
        $swap_pairs = [];
        $support_pairs = unserialize($this->swap_pairs);
        if(count($support_pairs) > 0) {
            foreach ($support_pairs as $pair) {
                $swap_pairs[] = SwapPair::find($pair);
            }
        }
        return $swap_pairs;
    }

    public function get_swap_wallets() {
        $swap_wallets = SwapWallet::where('user_id', $this->id)->get();
        return $swap_wallets;
    }
}
