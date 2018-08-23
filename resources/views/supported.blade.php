@extends('layouts.app')

@section('content')
    <div id="supported-header" class="page-header header-filter header-small" data-parallax="true">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <div class="brand">
                        <h1 class="title">Supported Coins</h1>
                        <h4>A current list of coins which Switcheroo can swap.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main main-raised">
        <div class="section">
            <div class="container">
                <h2 class="section-title">Coins Offering Swaps</h2>
                <div class="row justify-content-center">
                    @if(count($active_coins) > 0)
                        @foreach($active_coins as $coin)
                            <div class="col-md-4">
                                <div class="card card-product card-plain">
                                    <div class="card-header card-header-image">
                                        <a href="{{route('info', $coin->ticker)}}">
                                            <img src="https://ip.bitcointalk.org/?u=http%3A%2F%2Fresqchain.org%2Fwp-content%2Fuploads%2F2018%2F07%2FRESQ-White.png&t=592&c=sV3r-SAaGAGddQ" alt="">
                                        </a>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title">
                                            <a href="#pablo">Resq Chain</a>
                                        </h4>
                                        <p class="card-description">{{$active_coins_infos[$coin->id - 1]->header}}</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="price-container">
                                            <span class="price"> Coins Available To Swap: {{count(unserialize($coin->supported_swaps))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4>No Coins Have Been Added To The Platform Yet! Check Back Soon!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection