<div class="card mb-2">
    @if ($successes->contains('challenge_id', 2))
        <div class="card-body">
            <h4 class="card-title">Persistent XSS</h4>
            <p class="card-text">Persistent XSS occurs when a page outputs untrusted stored data without proper validation or escaping.</p>
        </div>
        <div class="alert-success card-footer" role="alert">
            <h5 class="pt-2 pb-1"><i class="bi bi-check-circle-fill mr-2"></i>Solved!</h5>
        </div>
    @else
        <div class="card-body">
            <h4 class="card-title">Persistent XSS</h4>
            <p class="card-text">Persistent XSS occurs when a page outputs untrusted stored data without proper validation or escaping.</p>
        </div>
        <form class="form-inline card-footer" action="{{route('challenges.attempt')}}" method="POST">
            @csrf
            <div class="form-inline my-1 mr-sm-2">
                <label for="challenge_id" class="sr-only">Flag</label>
                <input type="hidden" class="form-control" name="challenge_id" id="challenge_id" value="2">
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
