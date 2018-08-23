<?php
/**
 * A view which allows users to select a swap
 * asset for which they would like to deposit
 * to initiate swap.
 *
 * User: Notorious
 * Date: 8/21/2018
 * Time: 3:22 PM
 */

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection