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
                                            <button type="button" class="btn btn-white btn-round w-100" data-toggle="modal" data-target="#deposit-modal-{{$pair->dead_id.'_'.$pair->active_id}}">
                                                <i class="material-icons">input</i> Deposit Address
                                            </button>
                                            <button type="button" class="btn btn-white btn-round w-100" data-toggle="modal" data-target="#manage-modal-{{$pair->dead_id.'_'.$pair->active_id}}">
                                                <i class="material-icons">settings</i> Manage
                                            </button>
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
    @if(count(unserialize(Auth::user()->swap_pairs)) > 0)
        @foreach(Auth::user()->get_swap_pairs() as $pair)
            <!-- Deposit Modal -->
            <div class="modal fade" id="deposit-modal-{{$pair->dead_id.'_'.$pair->active_id}}"
                 tabindex="-1" role="dialog"
                 aria-labelledby="deposit-modal-{{$pair->dead_id.'_'.$pair->active_id}}-label"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="deposit-modal-{{$pair->dead_id.'_'.$pair->active_id}}-label">
                                {{$pair->get_dead_coin()->name}} Deposit Address For Swap
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            To swap {{$pair->get_dead_coin()->name}} for {{$pair->get_active_coin()->name}}, simply
                            deposit your {{$pair->get_dead_coin()->ticker}} to the given address, and once the payment
                            has been confirmed your {{$pair->get_active_coin()->ticker}} will automatically be sent to your
                            destination wallet!
                            <br>
                            <div class="p-3" style="border-radius: 3px; border: 1px solid #1b1e21;">
                                <h5>{{$pair->get_active_coin()->name}} Destination Address: {{Auth::user()->get_active_wallet_address($pair->id)}}</h5>
                                <h6 class="text-danger">Ensure this address correct before sending any coins!</h6>
                            </div>
                            <h5>Deposit Address</h5>
                            <p class="p-3" style="border-radius: 3px; border: 1px solid #1b1e21;">{{Auth::user()->get_dead_wallet_address($pair->dead_id)}}</p>
                            <p class="text-danger">Please only send <b>{{$pair->get_dead_coin()->name}} ({{$pair->get_dead_coin()->ticker}})</b> to this address! Any other coins will be rejected and lost forever!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Manage Modal -->
            <div class="modal fade" id="manage-modal-{{$pair->dead_id.'_'.$pair->active_id}}"
                 tabindex="-1" role="dialog"
                 aria-labelledby="manage-modal-{{$pair->dead_id.'_'.$pair->active_id}}-label"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="manage-modal-{{$pair->dead_id.'_'.$pair->active_id}}-label">
                                <b>{{$pair->get_dead_coin()->name}}</b> to <b>{{$pair->get_active_coin()->name}}</b> Swap Pair Overview
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="address-destination-label">{{$pair->get_active_coin()->name}} Address</label>
                                    <input type="text" class="form-control" id="address-destination-label"
                                           placeholder="QVFMQiCndRK6xpGN3RP1YSaa65gHV3kdXZ"
                                           value="{{Auth::user()->get_active_wallet_address($pair->id)}}">
                                </div>
                                <button type="submit" class="btn btn-success">Apply</button>
                            </form>
                            <ul class="list-group">
                                <li class="list-group-item">Pending Deposits: 0 {{$pair->get_dead_coin()->ticker}}</li>
                                <li class="list-group-item">Total Deposited: 0 {{$pair->get_dead_coin()->ticker}}</li>
                                <li class="list-group-item">Total Received: 0 {{$pair->get_active_coin()->ticker}}</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal">Remove Pair</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
