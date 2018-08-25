<?php

namespace App\Console\Commands;

use App\Coin;
use App\Swap;
use App\Transaction;
use App\User;
use App\SwapWallet;
use App\SwapPair;
use Illuminate\Console\Command;
use function PHPSTORM_META\map;

class SweepSwapWallets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:sweep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks wallets for balances greater than 0 and confirmations greater than 6, and swaps the total balance.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $active_rpc_clients = [];
        $dead_rpc_clients = [];
        $swap_wallets = SwapWallet::all();
        if(count($swap_wallets) > 0) {
            foreach ($swap_wallets as $swap_wallet) {
                $swap_pair = $swap_wallet->get_swap_pair();
                $user = User::find($swap_wallet->user_id);
                if($user && $swap_pair && $swap_wallet->is_active_wallet_valid()) {
                    $active_coin = $swap_pair->get_active_coin();
                    $dead_coin = $swap_pair->get_dead_coin();
                    if($active_coin && $dead_coin) {
                        if(key_exists($dead_coin->id, $dead_rpc_clients)) {
                            $dead_rpc_client = $dead_rpc_clients[$dead_coin->id];
                        } else {
                            $dead_rpc_client = $dead_coin->get_rpc_client();
                            $dead_rpc_clients[$dead_coin->id] = $dead_rpc_client;
                        }
                        if($dead_rpc_client && $dead_rpc_client->is_connected()) {
                            // Get balance with more than 5 confirmations
                            $dead_balance = $dead_rpc_client->getbalance($user->email, 6);
                            if($dead_balance > 1) {
                                if(key_exists($active_coin->id, $active_rpc_clients)) {
                                    $active_rpc_client = $active_rpc_clients[$active_coin->id];
                                } else {
                                    $active_rpc_client = $active_coin->get_rpc_client();
                                    $active_rpc_clients[$active_coin->id] = $active_rpc_client;
                                }
                                if($active_rpc_client->validateaddress($swap_wallet->active_address)['isvalid']) {
                                    $dead_txid = $dead_rpc_client->move($user->email, "", $dead_balance);
                                    if($dead_txid) {
                                        $user_amount = $dead_balance * ((double)$swap_pair->active_ratio / $swap_pair->dead_ratio);
                                        $fee_amount = $user_amount * ($active_coin->fee / 100.0);
                                        $user_amount -= $fee_amount;
                                        $user_txid = $active_rpc_client->sendtoaddress($swap_wallet->active_address, $user_amount);
                                        if ($user_txid && is_string($user_txid)) {
                                            $user_transaction = $this->create_transaction_record($active_coin, $user_amount,
                                                $swap_wallet->active_address, $user_txid);
                                            Swap::create([
                                                'pair_id' => $swap_pair->id,
                                                'wallet_id' => $swap_wallet->id,
                                                'transaction_id' => $user_transaction->id,
                                                'input_amount' => $dead_balance,
                                                'output_amount' => $user_amount
                                            ]);
                                            $fee_txid = $active_rpc_client->sendtoaddress($swap_wallet->active_fee_address, $fee_amount);
                                            if ($fee_txid && is_string($fee_txid)) {
                                                $this->create_transaction_record($active_coin, $fee_amount,
                                                    $swap_wallet->active_fee_address, $fee_txid);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $coin_id
     * @param $amount
     * @param $address
     * @param $txid
     * @return mixed
     */
    public function create_transaction_record($coin_id, $amount, $address, $txid)
    {
        $transaction = Transaction::create([
            'coin_id' => $coin_id->id,
            'amount' => $amount,
            'output_address' => $address,
            'txid' => $txid
        ]);
        return $transaction;
    }
}
