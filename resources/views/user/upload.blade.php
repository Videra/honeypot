<div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('home')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Upload avatar</label>
        <div class="input-group">
            <input required type="file" accept="image/png, image/jpeg" name="avatar" class="form-control">
            <input type="submit" value="Upload" class="btn btn-primary">
        </div>
    </form>
</div>
