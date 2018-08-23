<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SwapPair;

class Coin extends Model
{
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
}
