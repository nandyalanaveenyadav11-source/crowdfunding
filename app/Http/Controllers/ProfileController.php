<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Restriction: Cannot delete if active campaigns or debt/equity based campaigns exist
        $hasRestrictedCampaigns = \App\Models\Campaign::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('status', 'approved')
                      ->orWhereIn('type', ['debt', 'equity']);
            })
            ->exists();

        if ($hasRestrictedCampaigns) {
            return Redirect::route('profile.edit')->with('error', 'Account deletion restricted: You have active campaigns or ongoing financial obligations (Debt/Equity). Please settle these before closing your account.');
        }

        // MASTER KEY: Direct query to force the update
        \Illuminate\Support\Facades\DB::table('users')
            ->where('id', $user->id)
            ->update(['delete_requested' => true]);
        
        try {
            // Notify Admin
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new \App\Notifications\DeletionRequestNotification($user));
            }
            // Notify User
            $user->notify(new \App\Notifications\DeletionRequestUserConfirmation());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Deletion Request Email Error: " . $e->getMessage());
        }

        return Redirect::route('profile.edit')->with('status', 'deletion-requested')->with('success', 'YOUR DELETION REQUEST WAS RECEIVED SUCCESSFULLY!');
    }
}
