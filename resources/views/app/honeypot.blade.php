@extends('app')

@section('title', 'Honeypot')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                    @guest
                        <h5 class="card-title">Welcome, guest</h5>
                        <p class="card-text">Please login or register to access our CTF challenges</p>
                    @else
                        <h5 class="card-title">Welcome, {{ Auth()->user()->name }}</h5>
                        <p class="card-text">You have solved {{ count(Auth()->user()->successes) }} challenge/s.</p>
                    @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

