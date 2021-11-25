<?php

namespace App\Observers;

use App\Events\UpdatedUser;
use App\Events\XSSAttempted;
use App\Models\Challenge;
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
