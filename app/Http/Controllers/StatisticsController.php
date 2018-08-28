<?php

namespace App\Http\Controllers;

use App\SwapPair;
use App\User;
use DateTime;
use App\Coin;
use App\Swap;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $swaps = Swap::orderBy('created_at', 'asc')->get();
        $swap_data = array(
            'input_labels'      => [],
            'input_values'      => [],
            'output_values'     => []
        );
        $last_date = null;
        $last_input_amount = 0;
        $last_output_amount = 0;
        $pair_histogram = [];
        foreach ($swaps as $swap) {
            $current_date = new DateTime($swap->created_at);
            if(!key_exists($swap->pair_id, $pair_histogram)) {
                $pair_histogram[$swap->pair_id] = 1;
            } else {
                $pair_histogram[$swap->pair_id] += 1;
            }
            if(!$last_date) {
                $last_date = $current_date;
                $swap_data['input_labels'][] = $current_date->getTimestamp();
                $last_input_amount = $swap->input_amount;
                $last_output_amount = $swap->output_amount;
                $swap_data['input_values'][] = $last_input_amount;
                $swap_data['output_values'][] = $last_output_amount;
            } else {
                $diff = $current_date->diff($last_date);
                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);
                $last_input_amount += $swap->input_amount;
                $last_output_amount += $swap->output_amount;
                if($hours >= 1) {
                    $last_date = $current_date;
                    $swap_data['input_labels'][] = $current_date->getTimestamp();
                    $swap_data['input_values'][] = $last_input_amount;
                    $swap_data['output_values'][] = $last_output_amount;
                } else {
                    $swap_data['input_values'][count($swap_data['input_values']) - 1] = $last_input_amount;
                    $swap_data['output_values'][count($swap_data['output_values']) - 1] = $last_output_amount;
                }
            }
        }
        $popular_pair_id = -1;
        $popular_pair_poll = -1;
        foreach ($pair_histogram as $key => $value) {
            if($popular_pair_poll < $value) {
                $popular_pair_id = $key;
                $popular_pair_poll = $value;
            }
        }
        $popular_pair = $popular_pair_id == -1 ? 'N/A' : SwapPair::find($popular_pair_id)->get_active_coin()->name;
        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($swap_data['input_labels'])
            ->datasets([
                [
                    "label" => "Total Input Amount",
                    'backgroundColor' => "rgba(0, 188, 212, 0)",
                    'borderColor' => "rgba(0, 188, 212, 0.7)",
                    "pointBorderColor" => "rgba(0, 188, 212, 0.7)",
                    "pointBackgroundColor" => "rgba(0, 188, 212, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $swap_data['input_values'],
                ],
                [
                    "label" => "Total Output Amount",
                    'backgroundColor' => "rgba(233, 30, 99, 0)",
                    'borderColor' => "rgba(233, 30, 99, 0.7)",
                    "pointBorderColor" => "rgba(233, 30, 99, 0.7)",
                    "pointBackgroundColor" => "rgba(233, 30, 99, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $swap_data['output_values'],
                ]
            ])
            ->optionsRaw("{
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            displayFormats: {
                                quarter: 'MMM D'
                            }
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.4, // disables bezier curves
                    }
                }
            }");
        $user_count = count(User::all());
        $active_coins = Coin::where('active_project', true)->get();
        $dead_coins = Coin::where('active_project', false)->get();
        $input_amount = Swap::sum('input_amount');
        $output_amount = Swap::sum('output_amount');
        return view('statistics', compact('chartjs'))
            ->with('user_count', $user_count)
            ->with('most_popular', $popular_pair)
            ->with('active_coins', $active_coins)
            ->with('dead_coins', $dead_coins)
            ->with('input_amount', $input_amount)
            ->with('output_amount', $output_amount);
    }
}
