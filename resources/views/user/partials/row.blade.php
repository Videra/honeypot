<tr>
    <td style="width: 40px;">
        <img class="rounded-circle img-responsive" width="40" src="{{ asset('/'. $user->avatar) }}" alt="">
    </td>

    <td class="align-middle">{{ $user->name }}</td>

    <td class="align-middle">{{ $user->role() }}</td>

    <td class="align-middle">{{ $user->registrationDate() }}</td>

    <td class="align-middle">{{ $user->latestActivity() }}</td>

    <td class="align-middle">{{ $user->status() }} </td>

    <td class="align-middle">
        <form action="{{ route($user->is_enabled ? 'users.disable' : 'users.enable', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="submit" value="{{ $user->is_enabled ? 'Enabled' : 'Disabled' }}" class="btn {{ $user->is_enabled ? 'btn-primary' : 'btn-secondary' }}" style="min-width: 84px">
        </form>
    </td>
    <td class="align-middle">
        <form action="{{ route('users.delete', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash-fill align-middle"></i>
            </button>
        </form>
    </td>
</tr>
