@extends('errors::minimal')

@section('title', __('Service Under Maintenance'))
@section('code')
    <img class="image rounded-circle card-subtitle" height="75" src="{{ asset('/avatars/cat-busy.gif') }}" alt="">
@endsection
@section('message', __('See you on December 3, 2021!'))
