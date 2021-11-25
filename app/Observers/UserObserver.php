<?php

namespace App\Observers;

use App\Events\XSSDetected;
use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     */
    public function retrieved(User $user): void
    {
        if ($this->isXSS($user->name)) {
            User::where('id', $user->id)->update(['is_enabled' => 0]);
            event(new XSSDetected($user, $user->name));
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
