<tr>
    <td style="width: 40px;">
        <img class="rounded-circle img-responsive" width="40" src="{{ asset('/'. $user->avatar) }}" alt="">
    </td>
    <td class="align-middle">{{ $user->name }}</td>
    <td class="align-middle">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
    <td class="align-middle {{ $user->is_enabled ? 'text-success' : 'text-danger' }}">
        {{ $user->is_enabled ? 'Enabled' : 'Disabled' }}
    </td>
    <td class="text-center align-middle">TODO</td>
</tr>
