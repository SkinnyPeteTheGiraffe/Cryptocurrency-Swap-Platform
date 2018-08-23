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
                <a href="#" target="_blank" class="btn btn-info btn-rose btn-lg">
                    <i class="material-icons">person_add</i> Sign Up
                </a>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <img src="{{asset("images/main-logo-1.png")}}" alt="Splash screen logo displaying swapping process." height="512px">
            </div>
        </div>
    </div>
</div>
<div class="main main-raised">
    <div class="container">
    </div>
</div>
<footer class="footer footer-default">
    <div class="container">
        <nav class="float-left">
            <ul>
                <li>
                    <a href="https://www.creative-tim.com">
                        Creative Tim
                    </a>
                </li>
                <li>
                    <a href="https://creative-tim.com/presentation">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="https://www.creative-tim.com/license">
                        Licenses
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright float-right">
            &copy;2018, made with <i class="material-icons">favorite</i> by
            <a href="https://www.creative-tim.com" target="_blank">Noto</a> for a better web.
        </div>
    </div>
</footer>
@endsection