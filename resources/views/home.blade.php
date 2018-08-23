@extends('layouts.app')

@section('content')
    <div class="profile-page sidebar-collapse">
        <div id="welcome-header" class="page-header header-filter" data-parallax="true"></div>
        <div class="main main-raised">
            <div class="profile-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 ml-auto mr-auto">
                            <div class="profile">
                                <div class="name">
                                    <h3 class="text-light">Welcome {{Auth::user()->name}}!</h3>
                                    <h6 class="pt-5">Rank: Administrator</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav">
                        <li class="nav-item">
                            <h3 class="display-4" style="font-size: 2rem;">Your Swap Pairs</h3>
                        </li>
                        <li class="ml-auto">
                            <a href="#pablo" class="btn btn-success btn-round float-right mt-4">
                                <i class="material-icons">add</i> Add New Pair
                            </a>
                        </li>
                    </ul>
                    <div class="row">
                        @if(count(unserialize(Auth::user()->swap_pairs)) > 0)
                            @foreach(Auth::user()->get_swap_pairs() as $pair)
                                <div class="col-md-4">
                                    <div class="card card-background coin-card">
                                        <div class="card-body">
                                            <h6 class="card-category text-info">{{$pair->get_active_coin()->name}}</h6>
                                            <h3 class="card-title">{{$pair->get_dead_coin()->ticker}} <i class="material-icons">arrow_right_alt</i> {{$pair->get_active_coin()->ticker}}</h3>
                                            <h4 class="card-title">Ratio: {{$pair->dead_ratio.':'.$pair->active_ratio}}</h4>
                                            <h4 class="card-title">Fee: {{$pair->get_active_coin()->fee}}%</h4>
                                            <a href="#pablo" class="btn btn-white btn-round w-100">
                                                <i class="material-icons">input</i> Deposit Address
                                            </a>
                                            <a href="#pablo" class="btn btn-white btn-round w-100">
                                                <i class="material-icons">history</i> Swap History
                                            </a>
                                            <a href="#pablo" class="btn btn-white btn-round w-100">
                                                <i class="material-icons">settings</i> Manage
                                            </a>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-4">
                                <div class="card card-background coin-card">
                                    <div class="card-body">
                                        <h6 class="card-category text-info">Add Pairs To Start Swapping</h6>
                                        <a href="#"><h3 class="card-title"><i class="material-icons" style="font-size: 10rem;">add</i></h3></a>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
