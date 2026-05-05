<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        if ($campaign->status !== 'approved') {
            return back()->with('error', 'You cannot donate to a pending or rejected campaign.');
        }

        // Simulate Payment Transaction ID
        $transactionId = 'TRX-' . strtoupper(Str::random(10));

        $donation = Donation::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'amount' => $request->amount,
            'transaction_id' => $transactionId,
        ]);

        // Update campaign current_amount
        $campaign->increment('current_amount', $request->amount);

        // Send Notifications
        try {
            // To Donor
            if (Auth::check()) {
                Auth::user()->notify(new \App\Notifications\DonationSuccessful($donation));
            }
            // To Campaign Owner
            $campaign->user->notify(new \App\Notifications\NewDonationReceived($donation));
        } catch (\Exception $e) {
            // Silently fail if mail is not configured yet
            \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your donation! Transaction ID: ' . $transactionId);
    }
}
