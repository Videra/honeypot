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
        <input type="file" name="avatar">
        <input type="submit" value="Upload">
    </form>
</div>
