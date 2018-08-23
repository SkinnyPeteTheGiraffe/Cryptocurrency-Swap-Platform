<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class CoinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coins')->insert([
            'name'              => 'Resq Chain',
            'ticker'            => 'RESQ',
            'algorithm'         => 'x16s',
            'generation_type'   => 'POW',
            'host'              => '127.0.0.1',
            'port'              => 19977,
            'rpc_user'          => 'testing',
            'rpc_password'      => 'testing',
            'active_project'    => true,
            'exchanges'         => serialize([['Crex24', 'https://crex24.com/exchange/RESQ-BTC']]),
            'fee'               => 1.44,
            'created_at'        => Carbon::now()
        ]);

        DB::table('coins')->insert([
            'name'              => 'b-hash',
            'ticker'            => 'HASH',
            'algorithm'         => 'xevan',
            'generation_type'   => 'POW',
            'host'              => '127.0.0.1',
            'port'              => 17654,
            'rpc_user'          => 'testing',
            'rpc_password'      => 'testing',
            'active_project'    => false,
            'exchanges'         => serialize([]),
            'fee'               => 0,
            'created_at'        => Carbon::now()
        ]);
    }
}
