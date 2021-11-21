@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">

                    <div class="btn-group mb-2">
                        <a href="{{ route('admin') }}" type="submit" class="btn btn-outline-dark">Show all</a>
                        <a href="{{ route('users.active') }}" type="submit" class="btn btn-outline-dark">Show active</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Registration date</th>
                                    <th>Latest activity</th>
                                    <th>Status</th>
                                    <th>Access</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @isset($users)
                                @forelse ($users as $user)
                                    @include('user.partials.row')
                                @empty
                                    <tr>
                                        <td colspan="4"><em>'No users found'</em></td>
                                    </tr>
                                @endforelse
                            @endisset
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
