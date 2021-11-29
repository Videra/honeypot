<?php

namespace App\Http\Controllers;

use App\Events\AchievedImageUploadBypass;
use App\Events\AttemptedImageUploadBypass;
use App\Events\AttemptedMassAssignment;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    /**
     * Display the Ranking page
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::withCount('successes')
            ->whereNotIn('id', [1,2])
            ->orderBy('successes_count', 'desc')
            ->paginate(5);

        return view('app.honeypot')->with(compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('app.profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        if ($invalidInputs = is_mass_assignment($request->all())) {
            event(new AttemptedMassAssignment(Auth()->user(), $invalidInputs));
            return redirect()->back()->withErrors(['name' => 'Mass Assignment attempt failed, a kitten died.']);
        }

        $validation = Validator::make($request->all(), [
            'name' => [
                'string', // @TODO "Persistent XSS" vulnerability
                'nullable',
                'min:4',
                'unique:users,name,' . Auth()->user()->id,
            ],
            'avatar' => 'image|max:2048' //jpg, jpeg, png, bmp, gif, svg, or webp
        ]);

        if ($validation->fails()) {
            if ($validation->errors()->get('avatar')) {
                $file = $request->file('avatar');
                $name = $file->getClientOriginalName();
                event(new AttemptedImageUploadBypass(Auth()->user(), $name));
            }
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if (auth()->user()->id == 2 && $request->name != auth()->user()->name) {
            return redirect()->back()->withErrors(['name' =>'You cant rename the default admin.']);
        }

        $attributes = $this->uploadAvatar($request);
        auth()->user()->update(array_filter($attributes)); // @TODO "Mass Assignment" vulnerability

        return redirect()->back();
    }

    /**
     * Upload the avatar and check for the Challenge
     *
     * @param Request $request
     * @return array
     */
    private function uploadAvatar(Request $request): array
    {
        $attributes = $request->all();

        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (is_image_upload_bypass($extension)) {
                event(new AchievedImageUploadBypass(auth()->user(), $name));
            }

            $attributes['avatar'] = $request->avatar->storeAs('avatars', $name);
        }

        return $attributes;
    }
}
