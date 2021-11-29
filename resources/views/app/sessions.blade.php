@extends('app')

@section('title', 'Sessions')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body d-flex justify-content-center alert-light">
                        <img class="image rounded-circle card-subtitle" height="75" src="{{ asset('/avatars/cat-trash.gif') }}" alt="">
                        <div class="col col-md-5 btn-group-vertical">
                            <h5 class="card-title">Sessions manager</h5>
                            <p class="card-subtitle">If you close a session, that user will be disconnected!</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h4 class="card-header">Sessions</h4>
                    <div class="card-body">
                        @include('app.sessions.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
