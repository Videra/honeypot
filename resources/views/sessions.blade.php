@extends('layouts.app')

@section('title', 'Sessions')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Sessions</div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @include('sessions.table')

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
