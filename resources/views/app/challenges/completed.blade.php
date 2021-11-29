@extends('app')

@section('title', 'hacked')

@section('content')
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h4 class="text-white font-weight-bold">Congratulations {{ auth()->user()->name }}, you completed all the challenges!</h4>
                <img class="img-fluid" width="600" src="{{ asset('/avatars/nyan.gif') }}" alt="">
            </div>
        </div>
    </div>
    <script>
        function changeBackground(color) {
            document.body.style.background = color;
        }

        window.addEventListener("load",function() { changeBackground('#043164') });
    </script>
@endsection

