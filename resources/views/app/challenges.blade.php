@extends('app')

@section('title', 'Challenges')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @guest
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Welcome, guest</h5>
                            <p class="card-text">Please login or register to access our CTF challenges</p>
                        </div>
                    </div>
                @else
                    <div class="card-deck mb-4">
                        @include('app.challenges.broken_access_control')
                        @include('app.challenges.persistent_xss')
                        @include('app.challenges.mass_assignment')
                    </div>
                    <div class="card-deck">
                        @include('app.challenges.sql_injection')
                    </div>
                @endguest
            </div>
        </div>
    </div>
@endsection

