@extends('app')

@section('title', 'Honeypot')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body text-center alert-info">
                    @guest
                        <h5 class="card-title">Welcome, guest</h5>
                        <p class="card-text">Please login or register to access our CTF challenges</p>
                    @else
                        <h5 class="card-title">Welcome, {{ Auth()->user()->name }}</h5>
                        <p class="card-text">You have solved {{ count(Auth()->user()->successes) }} challenge/s.</p>
                    @endguest
                    </div>
                </div>
                <div class="card text-center">
                    <h5 class="card-header">Ranking</h5>
                    <div class="card-body border-bottom">
                @include('app.users.ranking')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

