<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Coin;
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

    public function get_wallet_address($coin_id) {
        $deposit_addresses = unserialize($this->deposit_addresses);
        if(!key_exists($coin_id, $deposit_addresses)){
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
        }
        return "Error retrieving deposit address!";
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
}
