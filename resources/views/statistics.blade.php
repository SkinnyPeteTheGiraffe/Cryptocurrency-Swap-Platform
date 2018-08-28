@extends('layouts.app')

@section('content')
    <div id="supported-header" class="page-header header-filter header-small" data-parallax="true">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <div class="brand">
                        <h1 class="title">Statistics</h1>
                        <h4>A overview of coin and swap related stats.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main main-raised">
        <div class="section">
            <div class="container">
                <div class="features-1">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto">
                            <h2 class="description text-center">Brief Summary</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-danger">
                                    <i class="material-icons">cached</i>
                                </div>
                                <h3 class="info-title">{{count($active_coins)}}</h3>
                                <p>{{count($active_coins) == 1 ? ' Coin' : ' Coins'}} Currently Offering Swaps</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-primary">
                                    <i class="material-icons">swap_horiz</i>
                                </div>
                                <h3 class="info-title">{{count($dead_coins)}}</h3>
                                <p>{{count($dead_coins) == 1 ? ' Coin' : ' Coins'}} Being Swapped Currently</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-warning">
                                    <i class="material-icons">people</i>
                                </div>
                                <h3 class="info-title">{{$user_count}}</h3>
                                <p>Users Currently Signed Up To the Platform</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-info">
                                    <i class="material-icons">input</i>
                                </div>
                                <h3 class="info-title">{{$input_amount}}</h3>
                                <p>Coins Have Been Sent In For Swaps</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-success">
                                    <i class="material-icons">send</i>
                                </div>
                                <h3 class="info-title">{{$output_amount}}</h3>
                                <p>Coins Have Been Sent Out For Swaps</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info">
                                <div class="icon icon-rose">
                                    <i class="material-icons">favorite</i>
                                </div>
                                <h3 class="info-title">{{$most_popular}}</h3>
                                <p>Is The Most Popular Coin Offering Swaps</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg">{!! $chartjs->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection