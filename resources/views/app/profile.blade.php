@extends('app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(auth()->user()->isAdmin())
                <div class="card-body text-center alert-success mb-2">
                    <h5 class="card-subtitle">You have administrator privileges</h5>
                    <p class="card-subtitle">{{ session('message') }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body border-bottom">
                    <div class="text-center">
                        <img class="image rounded-circle" src="{{ asset('/'.Auth()->user()->avatar)}}" alt="" style="width: 80px;height: 80px; padding: 10px; margin: 0px; ">
                    </div>

                    <form class="m-2" action="{{route('user.show')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input autofocus
                                       id="name"
                                       type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name"
                                       placeholder="{{ Auth()->user()->name }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">Profile image</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file"
                                       accept="image/png, image/jpeg"
                                       class="form-control @error('avatar') is-invalid @enderror"
                                       name="avatar"
                                       autocomplete="new-password">
                                @error('avatar')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3 col-8">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
