<div class="table-responsive">
    <table class="table table-borderless table-striped">
        <thead>
            <tr>
                @if (auth()->user()->is_admin)
                    <th>User Name</th>
                @endif
                <th>IP Address</th>
                <th>Device</th>
                <th>Browser</th>
                <th>Last activity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @isset($sessions)
            @forelse ($sessions as $session)
                @include('app.sessions.row')
            @empty
                <tr class="text-center">
                    <td colspan="6"><em>No sessions found</em></td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>
    {!! $sessions->links() !!}
</div>
