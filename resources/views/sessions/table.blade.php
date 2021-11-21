<div class="table-responsive">
    <table class="table table-borderless table-striped">
        <thead>
            <tr>
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
                @include('sessions.row')
            @empty
                <tr>
                    <td colspan="5"><em>'No sessions found'</em></td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>
    {!! $sessions->links() !!}
</div>
