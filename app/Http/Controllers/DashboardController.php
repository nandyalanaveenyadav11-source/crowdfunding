<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use App\Models\Donation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $campaigns = Campaign::where('user_id', $user->id)->latest()->get();
        $donations = Donation::where('user_id', $user->id)->with('campaign')->latest()->get();
        
        return view('dashboard', compact('campaigns', 'donations'));
    }
}
