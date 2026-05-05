@extends('layouts.app-custom')

@section('content')
<section class="hero">
    <div class="container">
        <span class="animate-fade-in" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; background: rgba(99, 102, 241, 0.08); color: var(--primary); border-radius: 99px; font-weight: 800; font-size: 0.85rem; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.1em; border: 1px solid rgba(99, 102, 241, 0.15);">
            <i data-lucide="sparkles" style="width: 16px; height: 16px;"></i> The Future of Fundraising
        </span>
        <h1 class="animate-fade-in">Bring your creative <br> ideas to life.</h1>
        <p class="animate-fade-in" style="animation-delay: 0.1s;">Join a global community supporting innovative technology, creative arts, and social causes. Your journey starts here.</p>
        
        <div class="search-wrapper animate-fade-in" style="animation-delay: 0.2s;">
            <form action="{{ route('campaigns.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search projects, creators, or categories..." class="search-input" value="{{ request('search') }}">
                <button type="submit" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; box-shadow: var(--shadow-md);" onmouseover="this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.transform='translateY(-50%) scale(1)'">
                    <i data-lucide="search" style="width: 22px; height: 22px;"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<div class="container" style="padding: 8rem 0;">
    <div style="display: flex; flex-direction: column; gap: 3.5rem; margin-bottom: 5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 2rem;">
            <div>
                <h2 style="font-size: 3rem; font-weight: 800; letter-spacing: -0.04em;">Discover Campaigns</h2>
                <p style="color: var(--text-muted); margin-top: 0.75rem; font-size: 1.15rem;">Curated projects across different funding models.</p>
            </div>
            <div style="display: flex; gap: 1rem; background: white; padding: 0.5rem; border-radius: 99px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                <a href="{{ route('campaigns.index') }}" class="btn {{ !request('type') ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.6rem 1.5rem; border-radius: 99px; border: none; {{ !request('type') ? '' : 'background: transparent;' }}">All Projects</a>
            </div>
        </div>
        
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; justify-content: center;">
            <a href="{{ route('campaigns.index', ['type' => 'donation']) }}" class="btn {{ request('type') == 'donation' ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.75rem 2rem; border-radius: 99px; min-width: 160px;">
                <i data-lucide="heart" style="width: 18px;"></i> Donation
            </a>
            <a href="{{ route('campaigns.index', ['type' => 'reward']) }}" class="btn {{ request('type') == 'reward' ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.75rem 2rem; border-radius: 99px; min-width: 160px;">
                <i data-lucide="gift" style="width: 18px;"></i> Reward
            </a>
            <a href="{{ route('campaigns.index', ['type' => 'equity']) }}" class="btn {{ request('type') == 'equity' ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.75rem 2rem; border-radius: 99px; min-width: 160px;">
                <i data-lucide="pie-chart" style="width: 18px;"></i> Equity
            </a>
            <a href="{{ route('campaigns.index', ['type' => 'debt']) }}" class="btn {{ request('type') == 'debt' ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.75rem 2rem; border-radius: 99px; min-width: 160px;">
                <i data-lucide="trending-up" style="width: 18px;"></i> Debt
            </a>
        </div>
    </div>

    @if($campaigns->isEmpty())
        <div style="text-align: center; padding: 10rem 0; background: white; border-radius: var(--radius-lg); border: 2px dashed var(--border);">
            <div style="background: #f1f5f9; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2.5rem;">
                <i data-lucide="search-x" style="width: 50px; height: 50px; color: #94a3b8;"></i>
            </div>
            <h3 style="font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">No results found</h3>
            <p style="color: var(--text-muted); margin-top: 1rem; font-size: 1.1rem; max-width: 450px; margin-left: auto; margin-right: auto;">We couldn't find any campaigns matching your criteria. Try adjusting your search or filters.</p>
            <a href="{{ route('campaigns.index') }}" class="btn btn-primary" style="margin-top: 3rem;">Browse All Campaigns</a>
        </div>
    @else
        <div class="grid-main">
            @foreach($campaigns as $campaign)
            <div class="card animate-fade-in">
                <div class="card-img-wrapper">
                    <a href="{{ route('campaigns.show', $campaign) }}">
                        @if($campaign->image)
                            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="card-img">
                        @else
                            <div style="height: 100%; width: 100%; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="image" style="width: 40px; height: 40px; color: #cbd5e1;"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-overlay"></div>
                    <div style="position: absolute; top: 1.25rem; right: 1.25rem;">
                        <span class="badge" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); color: var(--text-main); border: 1px solid rgba(255,255,255,0.5); box-shadow: var(--shadow-sm);">
                            {{ ucfirst($campaign->type) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <span class="card-category">{{ $campaign->category }}</span>
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 600;">
                            <i data-lucide="clock" style="width: 14px; height: 14px;"></i> {{ \Carbon\Carbon::parse($campaign->deadline)->diffForHumans() }}
                        </div>
                    </div>
                    <h3 class="card-title"><a href="{{ route('campaigns.show', $campaign) }}">{{ $campaign->title }}</a></h3>
                    <p class="card-text">{{ Str::limit($campaign->description, 140) }}</p>
                    
                    <div style="margin-top: auto;">
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
                        </div>
                        <div class="progress-stats">
                            <div>
                                <span style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">${{ number_format($campaign->current_amount) }}</span>
                                <span style="color: var(--text-muted); font-weight: 500; font-size: 0.85rem;"> raised</span>
                            </div>
                            <div style="color: var(--primary); font-size: 1.1rem;">{{ $campaign->progress_percentage }}%</div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(226, 232, 240, 0.6); display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; color: var(--primary);">
                                {{ substr($campaign->user->name, 0, 1) }}
                            </div>
                            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">{{ $campaign->user->name }}</span>
                        </div>
                        <a href="{{ route('campaigns.show', $campaign) }}" style="font-size: 0.9rem; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; transition: 0.3s;" onmouseover="this.style.gap='0.75rem'" onmouseout="this.style.gap='0.5rem'">
                            Details <i data-lucide="arrow-right" style="width: 16px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 6rem; display: flex; justify-content: center;">
            {{ $campaigns->links() }}
        </div>
    @endif
</div>

<section style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 10rem 0; margin-top: 4rem; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 70% 30%, rgba(99, 102, 241, 0.15), transparent); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; text-align: center; color: white;">
        <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 20px; margin-bottom: 2rem; backdrop-filter: blur(10px);">
            <i data-lucide="rocket" style="width: 40px; height: 40px; color: var(--primary-light);"></i>
        </div>
        <h2 style="font-size: 4rem; font-weight: 800; margin-bottom: 2rem; letter-spacing: -0.05em; line-height: 1.1;">Ready to change <br> the world?</h2>
        <p style="color: #94a3b8; font-size: 1.35rem; max-width: 650px; margin-bottom: 4rem; font-weight: 400;">Join thousands of visionary creators who have successfully funded their dreams and built communities on CrowdFund.</p>
        <div style="display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center;">
            <a href="{{ route('campaigns.create') }}" class="btn btn-primary" style="padding: 1.25rem 3.5rem; font-size: 1.15rem; border-radius: 99px;">
                Start a Campaign <i data-lucide="arrow-right" style="width: 20px;"></i>
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline" style="border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white; padding: 1.25rem 3.5rem; font-size: 1.15rem; border-radius: 99px; backdrop-filter: blur(10px);">
                Join Community
            </a>
        </div>
    </div>
</section>
@endsection
