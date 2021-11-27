<?php

namespace App\Http\Controllers;

use App\Events\ChallengeAttempted;
use App\Events\ChallengeCompleted;
use App\Models\Challenge;
use App\Models\Success;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $challenges = Challenge::all();
        $successes = Auth()->user()->successes()->get();

        return view('app.challenges', compact('successes', 'challenges'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function attempt(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'flag' => 'required|alpha_num|size:10',
            'challenge_id' => 'required|integer|exists:challenges,id|unique:successes,challenge_id,NULL,NULL,user_id,'.Auth()->user()->id
        ])->validate();

        $challenge = Challenge::where('id', $request->challenge_id)
            ->where('flag', $request->flag)
            ->first();

        if ($challenge) {
            Success::create([
                'challenge_id' => $challenge->id,
                'user_id' => $request->user()->id
            ]);

            event(new ChallengeCompleted($request->user(), $challenge));
        } else {
            event(new ChallengeAttempted($request->user(), Challenge::find($request->challenge_id)));
        }

        return redirect()->back();
    }
}
