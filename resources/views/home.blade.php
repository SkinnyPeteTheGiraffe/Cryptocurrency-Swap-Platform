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
                        <div class="col-md-4">
                            <div class="card card-background coin-card">
                                <div class="card-body">
                                    <h6 class="card-category text-info">Resq Chain</h6>
                                    <h3 class="card-title">OPL <i class="material-icons">arrow_right_alt</i> RESQ</h3>
                                    <h4 class="card-title">Ratio: 1:3</h4>
                                    <h4 class="card-title">Fee: 1.2%</h4>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
