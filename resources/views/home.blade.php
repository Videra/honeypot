@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->avatar)
                        <img class="image rounded-circle" src="{{asset('/storage/avatars/'.Auth::user()->avatar)}}" alt="👤" style="width: 80px;height: 80px; padding: 10px; margin: 0px; ">
                        @endif
                    {{ __('You are logged in!') }}
                </div>
                <div class="card-body">
                    <form action="{{route('home')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar">
                        <input type="submit" value="Upload">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
