@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="btn-group mb-2">
                        <button disabled class="btn btn-dark">Show</button>
                        <a href="{{ route('users') }}"
                           class="btn {{ Request::is('users') ? 'btn-dark' : 'btn-outline-dark'}}">all</a>
                        <a href="{{ route('users.user') }}"
                           class="btn {{ Request::is('users.user') ? 'btn-dark' : 'btn-outline-dark'}}">user</a>
                        <a href="{{ route('users.admin') }}"
                           class="btn {{ Request::is('users/admin') ? 'btn-dark' : 'btn-outline-dark'}}">admin</a>
                        <a href="{{ route('users.active') }}"
                           class="btn {{ Request::is('users/active') ? 'btn-dark' : 'btn-outline-dark'}}">active</a>
                        <a href="{{ route('users.enabled') }}"
                           class="btn {{ Request::is('users/enabled') ? 'btn-dark' : 'btn-outline-dark'}}">enabled</a>
                        <a href="{{ route('users.disabled') }}"
                           class="btn {{ Request::is('users/disabled') ? 'btn-dark' : 'btn-outline-dark'}}">disabled</a>
                    </div>

                    @include('users.table')

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
