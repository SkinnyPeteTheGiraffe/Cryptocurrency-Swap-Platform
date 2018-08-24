@extends('layouts.app')

@section('content')
    <div class="product-page sidebar-collapse">
        <div id="info-header" class="page-header header-filter" data-parallax="true">
            <div class="container">
                <div class="row title-row">
                    <div class="col-md-4 ml-auto">

                    </div>
                </div>
            </div>
        </div>
        <div class="section section-gray">
            <div class="container">
                <div class="main main-raised main-product">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h2 class="title"> {{$coin->name}} </h2>
                            @if(!$rpc_client->is_connected())
                                <h6 class="sub-title">Connected: <span class="text-danger">&#8226;</span></h6>
                            @else
                                <h6 class="sub-title">Connected: <span class="text-success">&#8226;</span></h6>
                            @endif
                            <div id="accordion" role="tablist">
                                <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true"
                                               aria-controls="collapseOne">
                                                Description
                                                <i class="material-icons">keyboard_arrow_down</i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingOne"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <p>{{$info->body}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo"
                                               aria-expanded="false" aria-controls="collapseTwo">
                                                Coin Specifications
                                                <i class="material-icons">keyboard_arrow_down</i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <ul>
                                                <li><h6 class="info-title">Consensus Type: <span class="font-weight-light">{{$coin->generation_type}}</span></h6></li>
                                                <li><h6 class="info-title">Algorithm: <span class="font-weight-light">{{$coin->algorithm}}</span></h6></li>
                                                @if($rpc_client->is_connected())
                                                    <li><h6 class="info-title">Block Height: <span class="font-weight-light">{{$rpc_client->getblockcount()}}</span></h6></li>
                                                    <li><h6 class="info-title">Network Hashrate: <span class="font-weight-light">{{round($rpc_client->getmininginfo()['networkhashps'] / 1000000000, 2)}} GH/s</span></h6></li>
                                                    <li><h6 class="info-title">Network Difficulty: <span class="font-weight-light">{{round($rpc_client->getdifficulty(), 4)}}</span></h6></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree"
                                               aria-expanded="false" aria-controls="collapseThree">
                                                Exchanges
                                                <i class="material-icons">keyboard_arrow_down</i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel"
                                         aria-labelledby="headingThree"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            @if(count(unserialize($coin->exchanges)) > 0)
                                                <ul>
                                                    @foreach(unserialize($coin->exchanges) as $exchange)
                                                        <li><a href="{{$exchange[1]}}">{{$exchange[0]}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No exchanges have been added yet! Check back soon as we update the list periodically!</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div id="accordion" role="tablist">
                                <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="headingFour">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseFour" aria-expanded="true"
                                               aria-controls="collapseFour">
                                                Supported Swap Coins
                                                <i class="material-icons">keyboard_arrow_down</i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseFour" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingFour"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Ticker</th>
                                                        <th>Ratio</th>
                                                        <th>Fee</th>
                                                        <th class="text-right">Add</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($coin->get_swap_pairs()) > 0 && $rpc_client->is_connected())
                                                        @foreach($coin->get_swap_pairs() as $pair)
                                                            <tr>
                                                                <td>{{$pair->get_dead_coin()->name}}</td>
                                                                <td>{{$pair->get_dead_coin()->ticker}}</td>
                                                                <td>{{$pair->dead_ratio.':'.$pair->active_ratio}}</td>
                                                                <td>{{$pair->get_active_coin()->fee}}%</td>
                                                                <td class="td-actions text-right">
                                                                    @if(!Auth::user()->owns_swap_pair($pair->id))
                                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-pair-modal-{{$pair->dead_id.'_'.$pair->active_id}}">
                                                                            <i class="material-icons">add</i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-disabled" disabled data-toggle="modal" data-target="#add-pair-modal-{{$pair->dead_id.'_'.$pair->active_id}}">
                                                                            <i class="material-icons">add</i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                No coins supported yet! Check back soon!
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($coin->get_swap_pairs()) > 0 && $rpc_client->is_connected())
        @foreach($coin->get_swap_pairs() as $pair)
            <!-- Modal -->
            <div class="modal fade" id="add-pair-modal-{{$pair->dead_id.'_'.$pair->active_id}}"
                 tabindex="-1" role="dialog" aria-labelledby="add-pair-modal-{{$pair->dead_id.'_'.$pair->active_id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add-pair-modal-{{$pair->dead_id.'_'.$pair->active_id}}-label">
                                Add Swap Pair For <b>{{$pair->get_dead_coin()->name}}</b> to <b>{{$pair->get_active_coin()->name}}</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('add_pair')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="pair_id" value="{{ $pair->id }}">
                                    <label for="address-destination-label">Destination {{$pair->get_active_coin()->name}} Address</label>
                                    <input name="destination_address" type="text" class="form-control" id="address-destination-label" placeholder="QVFMQiCndRK6xpGN3RP1YSaa65gHV3kdXZ">
                                </div>
                                <p class="text-danger">Please ensure you are entering a valid address and is correctly entered! Otherwise you could potentially lose your coins!</p>
                                <button type="submit" class="btn btn-success">Add Pair</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection