<tr>
    <td style="width: 40px;">
        <img class="rounded-circle img-responsive" width="40" src="{{ asset('/'. $user->avatar) }}" alt="">
    </td>

    <td class="align-middle">{{ $user->name }}</td>

    <td class="align-middle">{{ $user->is_admin ? 'Admin' : 'User' }}</td>

    <td class="align-middle">
        @if($user->latestSession())
            {{ Carbon\Carbon::parse($user->latestSession()->last_activity)->diffForHumans() }}
        @endif
    </td>

    <td class="align-middle">
        {{ $user->latestSession() ? 'Logged in' : 'Logged out' }}
    </td>

    <td class="align-middle">
        <form action="{{ route($user->is_enabled ? 'users.disable' : 'users.enable', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="submit" value="{{ $user->is_enabled ? 'Enabled' : 'Disabled' }}" class="btn {{ $user->is_enabled ? 'btn-primary' : 'btn-secondary' }}" style="min-width: 84px">
        </form>
    </td>
</tr>
