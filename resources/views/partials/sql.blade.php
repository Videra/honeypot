@if(session('sql'))
    <div class="container">
        <div class="card-body">
            <strong class="text-white bg-dark">  {{ session('sql')['query'] }}  </strong>
            <ul class="card mb-3">
                @isset(session('sql')['bindings'])
                    @foreach(session('sql')['bindings'] as $parameter)
                        <li>{{ $parameter }}</li>
                    @endforeach
                @endisset
            </ul>
        </div>
    </div>
@endif
