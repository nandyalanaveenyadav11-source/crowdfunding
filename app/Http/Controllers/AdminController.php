<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $campaigns = Campaign::with('user')->latest()->get();
        $users = User::latest()->get();
        return view('admin.dashboard', compact('campaigns', 'users'));
    }

    public function updateCampaignStatus(Request $request, Campaign $campaign)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $campaign->update(['status' => $request->status]);

        // Notify User if approved
        if ($request->status === 'approved') {
            $campaign->user->notify(new \App\Notifications\CampaignApprovedNotification($campaign));
        }

        return back()->with('success', 'Campaign status updated to ' . $request->status);
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin user.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
