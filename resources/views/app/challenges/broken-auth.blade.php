<div class="card">
    <div class="card-body">
        <h4 class="card-title">Broken Access Control</h4>
        <p class="card-text">Login with the default administrator account using brute force and submit here the flag
            that you found.</p>
        @if ($successes->contains('challenge_id', 1))
            <div class="alert alert-success" role="alert">
                <h5 class="alert-heading">You successfully solved this challenge</h5>
            </div>
        @else
            <form action="{{route('challenges.attempt')}}" method="POST">
                @csrf
                <div class="form-inline my-1 mr-sm-2">
                    <label for="challenge_id" class="sr-only">Flag</label>
                    <input type="hidden" class="form-control" name="challenge_id" id="challenge_id" value="1">
                    <label for="flag" class="sr-only">Flag</label>
                    <input type="text" name="flag" id="flag"
                           placeholder="Enter your flag here..."
                           class="form-control @error('flag') is-invalid @enderror
                           @error('challenge_id') is-invalid @enderror">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span class="invalid-feedback" role="alert"><strong>{{ $error }}</strong></span>
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="btn btn-primary my-1 align-top">Send</button>
            </form>
        @endif
    </div>
</div>
