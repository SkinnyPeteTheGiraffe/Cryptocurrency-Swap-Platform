@extends('layouts.app')

@section('content')
<div id="welcome-header" class="page-header header-filter" data-parallax="true">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="title">Got Dead Coins? Switcheroo Them!</h1>
                <h4>Using our platform you can take old, abandoned, outdated, or even once forgotten cryptocurrencies, and swap them
                for new active projects, such as Resq Coin!</h4>
                <br>
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="btn btn-danger btn-raised btn-lg">
                    <i class="fa fa-play"></i> Watch video
                </a>
                @guest
                    <a href="{{route('register') }}" class="btn btn-info btn-rose btn-lg">
                        <i class="material-icons">person_add</i> Sign Up
                    </a>
                @else
                    <a href="{{route('home') }}" class="btn btn-info btn-info btn-lg">
                        <i class="material-icons">person</i> Dashboard
                    </a>
                @endguest
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <img src="{{asset("images/main-logo-1.png")}}" alt="Splash screen logo displaying swapping process." height="512px">
            </div>
        </div>
    </div>
</div>
<footer class="footer footer-default pt-5">
    <div class="container">
        <nav class="float-left align-middle">
            <ul>
                <li>
                    <a href="https://www.creative-tim.com">
                        Partner Coins
                    </a>
                </li>
                <li>
                    <a href="https://creative-tim.com/presentation">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com">
                        Statistics
                    </a>
                </li>
                <li>
                    <a href="https://www.creative-tim.com/license">
                        Discord
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright float-right">
            &copy;2018, made with <i class="material-icons">favorite</i> by Noto.
        </div>
    </div>
</footer>
@endsection