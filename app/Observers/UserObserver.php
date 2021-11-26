<?php

namespace App\Observers;

use App\Events\DeletedUser;
use App\Events\UpdatedUser;
use App\Events\XSSAttempted;
use App\Exceptions\ObservableException;
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
        if ($this->isXSS($user->name)) {
            User::where('id', $user->id)->update(['is_enabled' => 0]);

            event(new XSSAttempted($user, $user->name));
        }
    }

    /**
     * Listen to the User updating event.
     *
     * @param User $user
     * @return void
     * @throws AuthorizationException
     */
    public function updating(User $user)
    {
        if ($this->isXSS($user->name)) {
            event(new XSSAttempted($user, $user->name));

            $challenge = Challenge::where('id', 2)->first(); // 2 = 'Persistent XSS'

            throw new AuthorizationException("Hacking attempt detected! Flag=$challenge->flag");
        }

        event(new UpdatedUser($user));
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
        if (Auth()->check()) {
            $actionUser = Auth()->user();
        } else {
            $actionUser = new User();
            $actionUser->name = 'guest';
        }

        if ($this->isXSS($user->name)) {
            event(new XSSAttempted($actionUser, $user->name));

            throw new AuthorizationException("Hacking attempt detected!");
        }

        event(new UpdatedUser($user));
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
     * @throws ObservableException()
     */
    public function saving(User $user)
    {
        if ($user->isDirty('is_enabled')) {
            if ($user->id == 1) {
                throw new ObservableException("You can't disable this user");
            }

            if (Auth::user()->id == $user->id) {
                throw new ObservableException("You can't disable this user");
            }
        }
    }

    /**
     * We detect XSS by asking the DOM engine if the loaded string loads children
     *
     * @param $string
     * @return bool
     */
    private function isXSS($string): bool
    {
        libxml_use_internal_errors(true);

        if ($xml = simplexml_load_string("<root>$string</root>")) {
            return $xml->children()->count() !== 0;
        }

        return false;
    }
}
