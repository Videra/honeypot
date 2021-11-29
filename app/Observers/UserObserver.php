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
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

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
        if (Auth()->user()->id == $user->id) {
            $isAchievedAdmin = $user->successes()->where('challenge_id', id_mass_assignment())->first();

            if (!$isAchievedAdmin && $user->is_admin == 1 && $user->id != 1 && $user->id != 2) {
                event(new AchievedMassAssignment(Auth()->user(), "$user->name became an admin"));
            }
        }

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
        throw new ObservableException("Deleting is not allowed.");
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
        if ($user->isDirty('is_enabled')) {
            if ($user->id == 1 || $user->id == 2) {
                throw new ObservableException("You can't disable the default admin");
            } else if (auth()->user()->id == $user->id) {
                throw new ObservableException("You can't disable your own user");
            }
        }
    }
}
