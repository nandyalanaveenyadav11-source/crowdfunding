<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::where('status', 'approved');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $campaigns = $query->latest()->paginate(9);
        return view('campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['user', 'donations.user', 'updates']);
        return view('campaigns.show', compact('campaign'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'category' => 'nullable|string',
            'type' => 'required|in:donation,reward,equity,debt',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reward_details' => 'nullable|string',
            'equity_details' => 'nullable|string',
            'repayment_details' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $data['image'] = $imagePath;
        }

        Campaign::create($data);

        return redirect()->route('dashboard')->with('success', 'Campaign created and pending approval.');
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:1',
            'deadline' => 'required|date',
            'category' => 'nullable|string',
            'type' => 'required|in:donation,reward,equity,debt',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reward_details' => 'nullable|string',
            'equity_details' => 'nullable|string',
            'repayment_details' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $data['image'] = $imagePath;
        }

        $campaign->update($data);

        return redirect()->route('dashboard')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();
        return redirect()->route('dashboard')->with('success', 'Campaign deleted.');
    }
}
