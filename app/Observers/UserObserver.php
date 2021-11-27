<?php

namespace App\Observers;

use App\Events\AchievedMassAssignment;
use App\Events\AchievedXSS;
use App\Events\AttemptedBrokenAccessControl;
use App\Events\CreatedUser;
use App\Events\DeletedUser;
use App\Events\UpdatedUser;
use App\Events\AttemptedXSS;
use App\Exceptions\ObservableException;
use App\Listeners\LogAttemptedBrokenAccessControl;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

/**
    Retrieved
    Creating
    Created
    Updating
    Updated
    Saving
    Saved
    Deleting
    Deleted
    Restoring
    Restored
 */
class UserObserver
{
    /**
     * Listen to the User retrieve event.
     * Disable any user that reached the database with XSS
     *
     * @param User $user
     */
    public function retrieved(User $user): void
    {
        if (is_challenge_xss($user->name)) {
            event(new AttemptedXSS($user, $user->name));
        }
    }

    /**
     * Listen to the User updating event.
     *
     * @param User $user
     * @return void
     */
    public function updating(User $user)
    {
        if (is_challenge_xss($user->name)) {
            event(new AchievedXSS($user, $user->name));
        }

        event(new UpdatedUser(Auth()->user(), $user));
    }

    /**
     * Listen to the User creating event.
     *
     * @param User $user
     * @return void
     * @throws AuthorizationException
     */
    public function creating(User $user)
    {
        if ($user->is_admin == 1) {
            event( new AttemptedBrokenAccessControl("Attempted to create an admin user"));
            throw new AuthorizationException("Hacking attempt detected!");
        }

        if (Auth()->check()) {
            $actionUser = Auth()->user();
        } else {
            $actionUser = new User();
            $actionUser->name = 'guest';
        }

        if (is_challenge_xss($user->name)) {
            event(new AttemptedXSS($actionUser, $user->name));
            throw new AuthorizationException("Hacking attempt detected!");
        }

        event(new CreatedUser($user));
    }

    /**
     * Listen to the User deleting event.
     *
     * @return void
     * @throws ObservableException()
     */
    public function deleting(User $user)
    {
        if ($user->id == 1 || Auth::user()->id == $user->id) {
            throw new ObservableException("You can't delete this user");
        }

        event(new DeletedUser(Auth()->user(), $user));
    }

    /**
     * Listen to the User saving event.
     *
     * @param User $user
     * @return void
     * @throws ObservableException
     */
    public function saving(User $user)
    {
        if ($user->is_admin == 1) {
            event(new AchievedMassAssignment(Auth()->user(), "$user->name became an admin"));
        }

        if ($user->isDirty('is_enabled')) {
            if ($user->id == 1) {
                throw new ObservableException("You can't disable this user");
            }

            if (Auth::user()->id == $user->id) {
                throw new ObservableException("You can't disable this user");
            }
        }
    }
}
