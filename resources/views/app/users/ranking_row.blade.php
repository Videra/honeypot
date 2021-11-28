<tr>
    <td style="width: 40px;">
        <img class="rounded-circle img-responsive" width="40" src="{{ asset('/'. $user->avatar) }}" alt="">
    </td>

    <td class="align-middle">{{ $user->name }}</td>

    <td class="align-middle">{{ $user->role() }}</td>

    <td class="align-middle">{{ $user->isEnabled() ? $user->status() : 'Disabled' }} </td>

    <td class="align-middle">{{ $user->lastActivity() }}</td>

    <td class="align-middle">{{ count($user->successes) }} </td>

    <td class="align-middle">{{ count($user->attempts) }} </td>
</tr>
