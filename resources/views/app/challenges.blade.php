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
                    <div class="row d-flex justify-content-center">
                        @forelse($challenges as $challenge)
                            <div class="col-sm-4 mb-4">
                                @include('app.challenges.challenge')
                            </div>
                        @empty
                            <div class="card mb-2">
                                <div class="card-body text-center alert-danger">
                                    <h4 class="card-title">Challenges not found</h4>
                                    <p class="card-text">This is not suppose to happen, an attacker must have deleted them.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if($successes->count() > 4)
                        <div class="text-center">
                            <a href="{{ route('challenges.completed') }}">
                                <img class="image rounded-circle" width="100" src="{{ asset('/avatars/nyan.gif') }}" alt="">
                            </a>
                        </div>
                    @endif
                @endguest
            </div>
        </div>
    </div>
@endsection

