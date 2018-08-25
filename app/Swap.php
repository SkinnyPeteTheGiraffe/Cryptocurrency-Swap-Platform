<?php

namespace App;

use App\SwapPair;
use App\SwapWallet;
use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pair_id', 'wallet_id', 'transaction_id', 'input_amount', 'output_amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pair_id', 'wallet_id', 'transaction_id', 'input_amount', 'output_amount',
    ];

    public function get_swap_pair() {
        $swap_pair = SwapPair::find($this->pair_id);
        return $swap_pair;
    }

    public function get_swap_wallet() {
        $swap_pair = SwapWallet::find($this->wallet_id);
        return $swap_pair;
    }

    public function get_transaction() {
        $transaction = Transaction::find($this->transaction_id);
        return $transaction;
    }
}
