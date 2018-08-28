<?php

namespace App\Http\Controllers;

use App\Swap;
use App\SwapPair;
use App\SwapWallet;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Process datatables of swaps ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function swaps()
    {
        $swaps_out = [];
        $swaps_data = Swap::all();
        if (count($swaps_data) > 0) {
            foreach ($swaps_data as $data) {
                $wallet = SwapWallet::find($data->wallet_id);
                if($wallet->user_id == Auth::user()->id) {
                    $pair = SwapPair::find($data->pair_id);
                    $transaction = Transaction::find($data->transaction_id);
                    $swap = array(
                        'pair'          => $pair->get_display_name(),
                        'input_amount'  => $data->input_amount,
                        'output_amount' => $data->output_amount,
                        'txid'          => $transaction->txid,
                        'explorer'      => $pair->get_active_coin()->get_coin_info()->url_explorer."/tx/".$transaction->txid
                    );
                    $swaps_out[] = $swap;
                }
            }
        }
        return Datatables::of($swaps_out)->make(true);
    }

}
