@extends('app')

@section('title', 'Sessions')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
