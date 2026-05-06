@extends('layouts.app-custom')

@section('content')
<div class="container">
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div style="margin-bottom: 2.5rem; padding: 0 1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;">Account</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Security & Settings</p>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <i data-lucide="layout-dashboard"></i> Overview
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link active">
                    <i data-lucide="user"></i> Profile Settings
                </a>
                <a href="{{ route('campaigns.create') }}" class="sidebar-link">
                    <i data-lucide="plus-circle"></i> Create Campaign
                </a>
                <div class="sidebar-title">Preferences</div>
                <a href="#" class="sidebar-link">
                    <i data-lucide="bell"></i> Notifications
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="shield-check"></i> Privacy
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div style="margin-bottom: 4rem;">
                <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 0.75rem;">Profile Settings</h1>
                <p style="color: var(--text-muted); font-size: 1.25rem;">Manage your personal information and security preferences.</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 3rem;">
                <!-- Profile Information -->
                <div class="form-card">
                    <div style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="background: rgba(99, 102, 241, 0.1); color: var(--primary); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="user-cog"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;">Personal Information</h2>
                            <p style="font-size: 0.9rem; color: var(--text-muted);">Update your account's profile information and email address.</p>
                        </div>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password -->
                <div class="form-card">
                    <div style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="lock"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;">Security</h2>
                            <p style="font-size: 0.9rem; color: var(--text-muted);">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    /* Styling the Breeze default form elements to match the premium theme */
    .form-card input[type="text"],
    .form-card input[type="email"],
    .form-card input[type="password"] {
        width: 100%;
        padding: 1.15rem 1.5rem;
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 1.05rem;
        transition: var(--transition-fast);
        background: #fcfdfe;
        margin-top: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .form-card input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.15);
    }
    .form-card label {
        display: block;
        font-weight: 800;
        font-size: 0.9rem;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .form-card button[type="submit"] {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.875rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-primary);
    }
    .form-card button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px var(--primary-glow);
    }
    .form-card .mt-2 { margin-top: 0.5rem; color: var(--accent); font-size: 0.85rem; font-weight: 600; }
</style>
@endsection
