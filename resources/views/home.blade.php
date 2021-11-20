@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card text-center">
                <div class="card-header">{{ __('User Profile') }}</div>

                <div class="card-body">
                    <img class="image rounded-circle" src="{{ asset('/'.Auth::user()->avatar)}}" alt="" style="width: 80px;height: 80px; padding: 10px; margin: 0px; ">
                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ Auth::user()->is_admin ? 'Admin' : 'User' }}</h6>
                </div>

                @include('user.partials.upload')

            </div>
        </div>
    </div>
</div>
@endsection
