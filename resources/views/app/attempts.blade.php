@extends('app')

@section('title', 'Attempts')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header">Attempts</h4>
                    <div class="card-body">
                        @include('app.attempts.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
