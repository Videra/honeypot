<div class="table-responsive">
    @isset($user_id)
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" value="" class="btn btn-outline-dark">
                <i class="bi bi-box-arrow-right"></i> Close all sessions from this user
            </button>
        </form>
    @endisset
    <table class="table table-borderless table-striped">
        <thead>
            <tr>
                @if (Auth::user()->is_admin)
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
                <tr>
                    <td colspan="5"><em>'No sessions found'</em></td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>
    {!! $sessions->links() !!}
</div>
