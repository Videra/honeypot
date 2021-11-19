<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'avatar' => ['required', 'image']
        ]);

        if ($validated) {
            $filename = Storage::putFile('avatars', $request->file('avatar'));

            // In case that we need to create a vulnerability
            // $filename = $request->image->getClientOriginalName();
            // $request->image->storeAs('avatars', $filename, 'public');

            Auth()->user()->update(['avatar' => $filename]);
        }

        return redirect()->back()->with('success', "Avatar successfully uploaded.");
    }
}
