<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin_id', 'header', 'body', 'url_explorer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
