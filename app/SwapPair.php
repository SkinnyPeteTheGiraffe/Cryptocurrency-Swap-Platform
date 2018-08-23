<?php

namespace App;

use App\Coin;
use Illuminate\Database\Eloquent\Model;

class SwapPair extends Model
{
    public function get_active_coin() {
        $coin = Coin::find($this->active_id);
        return $coin;
    }

    public function get_dead_coin() {
        $coin = Coin::find($this->dead_id);
        return $coin;
    }
}
