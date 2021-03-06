<tr>
    @if (Auth::user()->is_admin)
        <td class="align-middle">
            @if($session->user)
                <a href="{{ route('sessions.user', $session->user->id) }}">{{ $session->user->name }}</a>
            @endif
        </td>
    @endif
    <td class="align-middle">{{ $session->ip_address }}</td>
    <td class="align-middle">{{ $session->device() }}</td>
    <td class="align-middle">{{ $session->browser() }}</td>
    <td class="align-middle">{{ $session->lastActivity() }}</td>
    <td class="align-middle">
        <form action="{{ route('sessions.delete', $session->id) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" value="{{ $session->id }}" class="btn btn-outline-dark">
                <i class="bi bi-x-lg"></i>
            </button>
        </form>
    </td>
</tr>
