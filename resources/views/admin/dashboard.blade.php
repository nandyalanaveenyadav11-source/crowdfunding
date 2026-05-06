@extends('layouts.app-custom')

@section('content')
<div class="container">
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div style="margin-bottom: 2.5rem; padding: 0 1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; color: var(--accent);">Admin Panel</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Platform Management</p>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                    <i data-lucide="shield"></i> Overview
                </a>
                <a href="#campaign-moderation" class="sidebar-link">
                    <i data-lucide="megaphone"></i> All Campaigns
                </a>
                <a href="#user-directory" class="sidebar-link">
                    <i data-lucide="users"></i> User Management
                </a>
                <a href="#deletion-requests" class="sidebar-link" style="color: var(--error-color);">
                    <i data-lucide="user-x"></i> Deletion Requests
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="bar-chart-3"></i> Reports
                </a>
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <i data-lucide="arrow-left"></i> Back to User Area
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div style="margin-bottom: 4rem;">
                <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 0.75rem;">Platform Control</h1>
                <p style="color: var(--text-muted); font-size: 1.25rem; font-weight: 400;">Reviewing campaigns and managing community growth.</p>
            </div>

            <!-- Admin Stats -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 6rem;">
                <div class="stat-card grad-primary" style="padding: 1.5rem;">
                    <h3 style="font-size: 0.75rem;">Total Campaigns</h3>
                    <p class="stat-value" style="font-size: 2.25rem;">{{ $campaigns->count() }}</p>
                </div>
                <div class="stat-card grad-accent" style="padding: 1.5rem;">
                    <h3 style="font-size: 0.75rem;">Pending</h3>
                    <p class="stat-value" style="font-size: 2.25rem;">{{ $campaigns->where('status', 'pending')->count() }}</p>
                </div>
                <div class="stat-card grad-secondary" style="padding: 1.5rem;">
                    <h3 style="font-size: 0.75rem;">Total Users</h3>
                    <p class="stat-value" style="font-size: 2.25rem;">{{ $users->count() }}</p>
                </div>
                <div class="stat-card grad-primary" style="padding: 1.5rem; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                    <h3 style="font-size: 0.75rem;">Total Raised</h3>
                    <p class="stat-value" style="font-size: 2.25rem;">${{ number_format($campaigns->sum('current_amount')) }}</p>
                </div>
            </div>

            <div id="campaign-moderation" style="margin-bottom: 6rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem;">
                    <div style="background: var(--text-main); color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="clipboard-list" style="width: 20px; height: 20px;"></i>
                    </div>
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">Campaign Moderation</h2>
                </div>
                
                <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #fcfdfe; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Campaign</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Creator</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Goal</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Status</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $campaign)
                                <tr style="border-bottom: 1px solid var(--border); transition: var(--transition);">
                                    <td style="padding: 1.5rem;">
                                        <p style="font-weight: 800; color: var(--text-main);">{{ $campaign->title }}</p>
                                        <p style="font-size: 0.8rem; color: var(--text-muted);">{{ ucfirst($campaign->type) }} • {{ $campaign->category }}</p>
                                    </td>
                                    <td style="padding: 1.5rem; font-weight: 600;">{{ $campaign->user->name }}</td>
                                    <td style="padding: 1.5rem; font-weight: 700;">${{ number_format($campaign->goal_amount) }}</td>
                                    <td style="padding: 1.5rem;"><span class="badge badge-{{ $campaign->status }}">{{ $campaign->status }}</span></td>
                                    <td style="padding: 1.5rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            @if($campaign->status !== 'approved')
                                                <form action="{{ route('admin.campaigns.status', $campaign) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem;">Approve</button>
                                                </form>
                                            @endif
                                            @if($campaign->status !== 'rejected')
                                                <form action="{{ route('admin.campaigns.status', $campaign) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-color: var(--accent); color: var(--accent);">Reject</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($deletionRequests->count() > 0)
            <div id="deletion-requests" style="margin-bottom: 6rem; border: 2px solid var(--error-color); padding: 2rem; border-radius: var(--radius-lg); background: rgba(239, 68, 68, 0.05);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="background: var(--error-color); color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="user-x" style="width: 20px; height: 20px;"></i>
                    </div>
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em; color: var(--error-color);">Account Deletion Requests</h2>
                </div>
                
                <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #fcfdfe; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">User</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Reason</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deletionRequests as $user)
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 1.5rem;">
                                        <p style="font-weight: 800; color: var(--text-main);">{{ $user->name }}</p>
                                        <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $user->email }}</p>
                                    </td>
                                    <td style="padding: 1.5rem; color: var(--error-color); font-weight: 600;">User requested deletion</td>
                                    <td style="padding: 1.5rem;">
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('CRITICAL: This will permanently delete the user and all their data. Proceed?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background: var(--error-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600;">Confirm Permanent Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div id="user-directory">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem;">
                    <div style="background: var(--text-main); color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </div>
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">User Directory</h2>
                </div>
                
                <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #fcfdfe; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">User</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Role</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Joined</th>
                                <th style="padding: 1.5rem; font-weight: 800; color: #475569; font-size: 0.85rem; text-transform: uppercase;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 1.5rem;">
                                        <p style="font-weight: 800; color: var(--text-main);">{{ $user->name }}</p>
                                        <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $user->email }}</p>
                                    </td>
                                    <td style="padding: 1.5rem;">
                                        @if($user->isAdmin())
                                            <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary); border: 1px solid var(--primary-glow);">Admin</span>
                                        @else
                                            <span class="badge" style="background: #f1f5f9; color: #64748b; border: 1px solid var(--border);">Member</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1.5rem; color: var(--text-muted); font-weight: 500;">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td style="padding: 1.5rem;">
                                        @if(!$user->isAdmin())
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-color: var(--accent); color: var(--accent);">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
