<?php

namespace App\Listeners;

use App\Events\ChallengeCompleted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogChallengeCompleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ip = Request::ip();
        $this->url = Request::url();
    }

    /**
     * Handle the event.
     *
     * @param ChallengeCompleted $event
     */
    public function handle(ChallengeCompleted $event)
    {
        if ($event->challenge->id == id_mass_assignment()) {
            $event->user->is_admin = 1;
            $event->user->save();
        }

        Log::info("/{$event->user->name} from $this->ip visited $this->url and [ChallengeCompleted] [{$event->challenge->name}]");

        return redirect()->back()->with('message', "Congratulations, now you have admin privileges");
    }
}
