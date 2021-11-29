@extends('app')

@section('title', 'Honeypot')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-4">
                    @guest
                        @include('app.challenges.guest')
                    @else
                        @include('app.challenges.cat')
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

