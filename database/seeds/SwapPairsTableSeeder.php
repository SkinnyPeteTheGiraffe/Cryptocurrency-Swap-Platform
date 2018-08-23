<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class SwapPairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('swap_pairs')->insert([
            'active_id'     => 1,
            'active_ratio'  => 3,
            'dead_id'       => 2,
            'dead_ratio'    => 1,
            'created_at'    => Carbon::now()
        ]);
    }
}
