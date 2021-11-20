@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users Management</div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Latest activity</th>
                                    <th>Status</th>
                                    <th>Access</th>
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
