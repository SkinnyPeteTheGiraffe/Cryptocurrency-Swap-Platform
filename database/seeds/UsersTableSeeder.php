<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'                  => 'admin',
            'email'                 => 'admin@admin.com',
            'password'              => bcrypt('green444'),
            'user_group'            => 1,
            'deposit_addresses'     => serialize([]),
            'swap_pairs'            => serialize([]),
            'created_at'            => Carbon::now()
        ]);
    }
}
