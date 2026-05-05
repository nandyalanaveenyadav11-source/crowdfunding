@extends('layouts.app-custom')

@section('content')
<div class="container">
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div style="margin-bottom: 2.5rem; padding: 0 1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;">Dashboard</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Manage your presence</p>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}" class="sidebar-link active">
                    <i data-lucide="layout-dashboard"></i> Overview
                </a>
                <a href="{{ route('campaigns.create') }}" class="sidebar-link">
                    <i data-lucide="plus-circle"></i> Create Campaign
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link">
                    <i data-lucide="user"></i> Profile Settings
                </a>
                <div class="sidebar-title">My Activity</div>
                <a href="#" class="sidebar-link">
                    <i data-lucide="heart"></i> Contributions
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="megaphone"></i> My Campaigns
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div style="margin-bottom: 4rem;">
                <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 0.75rem;">Welcome back, {{ auth()->user()->name }}!</h1>
                <p style="color: var(--text-muted); font-size: 1.25rem; font-weight: 400;">Tracking your impact and managing your creative journeys.</p>
            </div>

            <!-- Stats Overview -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; margin-bottom: 6rem;">
                <div class="stat-card grad-secondary">
                    <div class="stat-icon-wrapper">
                        <i data-lucide="wallet" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h3>Total Contributed</h3>
                    <p class="stat-value">${{ number_format($donations->sum('amount')) }}</p>
                </div>
                <div class="stat-card grad-primary">
                    <div class="stat-icon-wrapper">
                        <i data-lucide="rocket" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h3>Active Campaigns</h3>
                    <p class="stat-value">{{ $campaigns->where('status', 'approved')->count() }}</p>
                </div>
                <div class="stat-card grad-accent">
                    <div class="stat-icon-wrapper">
                        <i data-lucide="clock" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h3>Pending Review</h3>
                    <p class="stat-value">{{ $campaigns->where('status', 'pending')->count() }}</p>
                </div>
            </div>

            <div style="margin-bottom: 6rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">My Campaigns</h2>
                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                        <i data-lucide="plus"></i> Start a Campaign
                    </a>
                </div>
                
                @if($campaigns->isEmpty())
                    <div style="background: white; border: 2px dashed var(--border); padding: 6rem; text-align: center; border-radius: var(--radius-lg);">
                        <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                            <i data-lucide="package-open" style="width: 40px; height: 40px; color: #94a3b8;"></i>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">No campaigns yet</h3>
                        <p style="color: var(--text-muted); margin-bottom: 2.5rem; font-size: 1.1rem; max-width: 400px; margin-left: auto; margin-right: auto;">Ready to bring your idea to life? Launch your first campaign today!</p>
                        <a href="{{ route('campaigns.create') }}" class="btn btn-primary" style="padding-left: 3rem; padding-right: 3rem;">Launch Campaign</a>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem;">
                        @foreach($campaigns as $campaign)
                            <div class="card">
                                <div class="card-body">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                                        <h3 style="font-size: 1.35rem; font-weight: 800; max-width: 70%; line-height: 1.2;">{{ $campaign->title }}</h3>
                                        <span class="badge badge-{{ $campaign->status }}">{{ $campaign->status }}</span>
                                    </div>
                                    <div class="progress-container" style="height: 0.7rem;">
                                        <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; font-weight: 800; margin-top: 0.5rem;">
                                        <span style="color: var(--text-main);">${{ number_format($campaign->current_amount) }}</span>
                                        <span style="color: var(--primary);">{{ $campaign->progress_percentage }}%</span>
                                    </div>
                                    <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                                        <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-outline" style="flex: 1; font-size: 0.85rem;">View</a>
                                        <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-outline" style="flex: 1; font-size: 0.85rem;">Edit</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem;">
                    <div style="background: var(--text-main); color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="history" style="width: 20px; height: 20px;"></i>
                    </div>
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">Contribution History</h2>
                </div>
                
                <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #fcfdfe; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1.75rem; font-weight: 800; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Campaign</th>
                                <th style="padding: 1.75rem; font-weight: 800; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Amount</th>
                                <th style="padding: 1.75rem; font-weight: 800; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                                <th style="padding: 1.75rem; font-weight: 800; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                                <tr style="border-bottom: 1px solid var(--border); transition: var(--transition);">
                                    <td style="padding: 1.75rem; font-weight: 800; color: var(--text-main); font-size: 1.1rem;">{{ $donation->campaign->title }}</td>
                                    <td style="padding: 1.75rem; font-weight: 800; color: var(--secondary); font-size: 1.25rem;">${{ number_format($donation->amount) }}</td>
                                    <td style="padding: 1.75rem;"><span class="badge badge-approved" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;">Verified</span></td>
                                    <td style="padding: 1.75rem; color: var(--text-muted); font-size: 1rem; font-weight: 500;">{{ $donation->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding: 6rem; text-align: center; color: var(--text-muted); font-style: italic; font-size: 1.1rem;">No contributions yet. Project discoveries await!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
