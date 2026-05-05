<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
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

        $donation = Donation::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaign->id,
            'amount' => $request->amount,
            'transaction_id' => 'API-' . strtoupper(Str::random(10)),
        ]);

        $campaign->increment('current_amount', $request->amount);

        return response()->json($donation, 201);
    }
}
