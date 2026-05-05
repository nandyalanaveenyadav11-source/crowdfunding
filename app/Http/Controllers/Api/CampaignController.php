<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        return Campaign::where('status', 'approved')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $campaign = Campaign::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        return response()->json($campaign, 201);
    }

    public function show(Campaign $campaign)
    {
        return $campaign->load(['user', 'donations.user']);
    }
}
