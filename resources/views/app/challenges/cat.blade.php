<div class="card">
    <div class="card-body d-flex justify-content-center alert-light">
        <div class="col col-md-1 mr-4">
            <img class="image rounded-circle card-subtitle" width="75" src="
            @if(count(Auth()->user()->attempts) <= 0)
                {{ asset('avatars/cat-love.gif') }}
            @elseif(count(Auth()->user()->attempts) < 3)
            {{ asset('avatars/cat-upset.gif') }}
            @elseif(count(Auth()->user()->attempts) < 6)
                {{ asset('avatars/cat-sad.gif') }}
            @elseif(count(Auth()->user()->attempts) < 9)
                {{ asset('avatars/cat-cry.gif') }}
            @elseif(count(Auth()->user()->attempts) >= 9)
            {{ asset('avatars/cat-broken.gif') }}
            @endif
            " alt="">
        </div>
        <div class="col col-md-5 btn-group-vertical">
            <h5 class="card-title">
                Hi, {{ Auth()->user()->name }}!
            </h5>
            <p class="card-subtitle">You have solved {{ count(Auth()->user()->successes) }} challenges and killed {{ count(Auth()->user()->attempts) }} kittens.</p>
        </div>
    </div>
</div>
