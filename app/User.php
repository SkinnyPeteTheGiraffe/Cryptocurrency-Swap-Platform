<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\SwapPair;
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
        'password', 'remember_token',
    ];

    public function get_swap_pairs() {
        $swap_pairs = [];
        if(count($this->swap_pairs) > 0) {
            foreach ($this->swap_pairs as $pair) {
                $swap_pairs[] = SwapPair::find($pair);
            }
        }
        return $swap_pairs;
    }
}
