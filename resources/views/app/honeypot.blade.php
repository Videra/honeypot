@extends('app')

@section('title', 'Honeypot')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    @guest
                        <div class="card-body text-center alert-warning">
                            <h5 class="card-title">Welcome, guest</h5>
                            <p class="card-subtitle">Please login to try the challenges, but remember, on every failed attempt... a kitten dies!</p>
                        </div>
                    @else
                        <div class="card-body text-center alert-info">
                            <h5 class="card-title">Welcome, {{ Auth()->user()->name }}</h5>
                            <p class="card-subtitle">You have solved {{ count(Auth()->user()->successes) }} challenges and killed {{ count(Auth()->user()->attempts) }} kittens.</p>
                        </div>
                    @endguest
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

