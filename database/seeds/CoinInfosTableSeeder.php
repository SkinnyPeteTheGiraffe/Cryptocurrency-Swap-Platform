<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class CoinInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coin_infos')->insert([
            'coin_id'           => 1,
            'header'            => 'RESQ chain was born from seeing a multitude of Dev abandoned projects where communities were trying to take over to regain some value to their investments.',
            'body'              => 'Dev abandoned projects are common occurrence in the blockchain space and can happen for multiple reasons (lack of funding, exit scams, personal issues or commitments). While a large majority of coins have no real use case, some of these coins have an underlying potential to succeed with the correct team and funding. RESQ aims to assist by providing funding viable, abandoned projects that show a strong community support in hope that the project can reach its true potential as well as return some value to initial project investors. This will be referred to as RESQ Revival.

In circumstances where projects have a strong community, but it is viewed that the project has nothing unique to offer, RESQ would approach the community with an offer for a coin swap to RESQ coin. This will be referred to as RESQ Swap.

RESQ Chain’s primary focus is to build and keep communities together to help them succeed, we believe that the value of blockchain technology is derived from the community that is willing to support it.

RESQ Chain will not try to recreate the wheel, and in any areas where there may be an overlap of strategy we will look at creating trusted partnerships with other blockchains.',
            'created_at'        => Carbon::now(),
            'url_explorer'      => 'http://explorer.resqchain.org:3001'
        ]);
    }
}
