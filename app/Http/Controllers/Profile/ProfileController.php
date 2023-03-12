<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Show the main profile page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile.
     * 
     * @param  \App\Http\Requests\User\Profile\ProfileUpdateRequest  $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();
        
        try {
            auth()->user()->update($validated);
        } catch (\Exception $e) {
            report($e);
            
            return redirect()->route('profile')->with('error', 'Profile could not be updated.');
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
