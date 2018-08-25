<?php

namespace App;

use App\Coin;
use Illuminate\Database\Eloquent\Model;

class SwapPair extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active_id', 'active_ratio', 'dead_id', 'dead_ratio', 'active_fee_address', 'active_address', 'dead_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'active_id', 'active_ratio', 'dead_id', 'dead_ratio', 'active_fee_address', 'active_address', 'dead_address',
    ];

    public function get_active_coin() {
        $coin = Coin::find($this->active_id);
        return $coin;
    }

    public function get_dead_coin() {
        $coin = Coin::find($this->dead_id);
        return $coin;
    }
}
