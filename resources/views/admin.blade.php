@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Panel') }}</div>
                <div class="card-body">
                    <div class="table-responsive" id="users-table-wrapper">
                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="min-width-80">Name</th>
                                <th class="min-width-80">Role</th>
                                <th class="min-width-80">Status</th>
                                <th class="text-center min-width-150">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($users)
                                @forelse ($users as $user)
                                    @include('user.partials.row')
                                @empty
                                    <tr>
                                        <td colspan="7"><em>'No users found'</em></td>
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
