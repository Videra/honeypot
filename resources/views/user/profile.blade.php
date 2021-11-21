<div class="card text-center">
    <div class="card-header">Profile</div>
    <div class="card-body border-bottom">
        <img class="image rounded-circle" src="{{ asset('/'.Auth::user()->avatar)}}" alt="" style="width: 80px;height: 80px; padding: 10px; margin: 0px; ">
        <h5 class="card-title">{{ Auth::user()->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ Auth::user()->is_admin ? 'Admin' : 'User' }}</h6>
    </div>

    @include('user.upload')

</div>
