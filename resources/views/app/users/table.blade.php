<div class="table-responsive">
    <table class="table table-borderless table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Role</th>
                <th>Registration date</th>
                <th>Status</th>
                <th>Latest activity</th>
                <th>Challenges</th>
                <th>Access</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @isset($users)
            @forelse ($users as $user)
                @include('app.users.row')
            @empty
                <tr class="text-center">
                    <td colspan="8"><em>No users found</em></td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>
    {!! $users->links() !!}
</div>
