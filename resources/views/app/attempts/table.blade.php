<div class="table-responsive">
    <table class="table table-borderless table-striped">
        <thead>
            <tr>
                <th>Challenge</th>
                <th>User</th>
                <th>Payload</th>
                <th>IP Address</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
        @isset($attempts)
            @forelse ($attempts as $attempt)
                @include('app.attempts.row')
            @empty
                <tr class="text-center">
                    <td colspan="5"><em>No attempts found</em></td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>
    {!! $attempts->links() !!}
</div>
