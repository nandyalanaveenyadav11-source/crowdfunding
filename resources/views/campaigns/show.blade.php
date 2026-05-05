@extends('layouts.app-custom')

@section('content')
<div style="background: white; border-bottom: 1px solid var(--border); padding: 6rem 0 4rem; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 100% 0%, rgba(99, 102, 241, 0.05), transparent); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
            <span class="badge" style="background: rgba(99, 102, 241, 0.08); color: var(--primary); border: 1px solid rgba(99, 102, 241, 0.1);">
                <i data-lucide="tag" style="width: 14px; margin-right: 6px;"></i> {{ $campaign->category }}
            </span>
            <span class="badge" style="background: rgba(16, 185, 129, 0.08); color: var(--secondary); border: 1px solid rgba(16, 185, 129, 0.1);">
                <i data-lucide="layers" style="width: 14px; margin-right: 6px;"></i> {{ ucfirst($campaign->type) }}
            </span>
        </div>
        <h1 style="font-size: 4.5rem; font-weight: 800; letter-spacing: -0.05em; line-height: 1.05; margin-bottom: 1.5rem; max-width: 900px;">{{ $campaign->title }}</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--bg-main); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); border: 2px solid white; box-shadow: var(--shadow-sm);">
                {{ substr($campaign->user->name, 0, 1) }}
            </div>
            <p style="font-size: 1.25rem; color: var(--text-muted); font-weight: 500;">
                Managed by <span style="color: var(--text-main); font-weight: 800;">{{ $campaign->user->name }}</span>
            </p>
        </div>
    </div>
</div>

<div class="container" style="padding: 6rem 0;">
    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 6rem;">
        <div>
            @if($campaign->image)
                <div style="border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-xl); margin-bottom: 5rem; border: 1px solid var(--border);">
                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" style="width: 100%; display: block; transition: 0.5s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                </div>
            @endif

            <div style="margin-bottom: 6rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
                    <div style="background: var(--text-main); color: white; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="book-open" style="width: 20px;"></i>
                    </div>
                    <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">Campaign Story</h2>
                </div>
                <div style="font-size: 1.25rem; color: #334155; line-height: 1.9; white-space: pre-line; letter-spacing: -0.01em;">
                    {{ $campaign->description }}
                </div>
            </div>

            @if(($campaign->type == 'reward' && $campaign->reward_details) || ($campaign->type == 'equity' && $campaign->equity_details) || ($campaign->type == 'debt' && $campaign->repayment_details))
                <div style="margin-bottom: 6rem; background: #fcfdfe; padding: 4rem; border-radius: var(--radius-xl); border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;">
                        <div style="background: var(--primary); color: white; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="award" style="width: 24px;"></i>
                        </div>
                        <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">
                            @if($campaign->type == 'reward') Reward Details
                            @elseif($campaign->type == 'equity') Equity Details
                            @elseif($campaign->type == 'debt') Repayment Terms
                            @endif
                        </h2>
                    </div>
                    <div style="font-size: 1.25rem; color: #334155; line-height: 1.9; white-space: pre-line;">
                        @if($campaign->type == 'reward') {{ $campaign->reward_details }}
                        @elseif($campaign->type == 'equity') {{ $campaign->equity_details }}
                        @elseif($campaign->type == 'debt') {{ $campaign->repayment_details }}
                        @endif
                    </div>
                </div>
            @endif

            @if($campaign->updates->isNotEmpty())
                <div style="margin-top: 8rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3.5rem;">
                        <div style="background: var(--secondary); color: white; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="megaphone" style="width: 20px;"></i>
                        </div>
                        <h2 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.03em;">Project Updates</h2>
                    </div>
                    @foreach($campaign->updates as $update)
                        <div style="background: white; border: 1px solid var(--border); padding: 4rem; border-radius: var(--radius-xl); margin-bottom: 2.5rem; box-shadow: var(--shadow-md); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                                <h3 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.02em;">{{ $update->title }}</h3>
                                <span style="font-size: 0.95rem; color: var(--text-muted); font-weight: 700; background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 99px;">{{ $update->created_at->format('M d, Y') }}</span>
                            </div>
                            <div style="color: #475569; line-height: 1.8; font-size: 1.15rem;">{{ $update->content }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <div style="position: sticky; top: 120px;">
                <div class="form-card" style="padding: 3.5rem;">
                    <div style="margin-bottom: 3rem;">
                        <div style="display: flex; align-items: baseline; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <span style="font-size: 3.5rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.05em;">${{ number_format($campaign->current_amount) }}</span>
                        </div>
                        <p style="color: var(--text-muted); font-weight: 600; font-size: 1.15rem;">raised of <span style="color: var(--text-main); font-weight: 800;">${{ number_format($campaign->goal_amount) }}</span> target</p>
                    </div>

                    <div class="progress-container" style="height: 0.85rem; margin-bottom: 2rem;">
                        <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 4rem;">
                        <div style="background: #f8fafc; padding: 1.5rem; border-radius: var(--radius-md); text-align: center; border: 1px solid var(--border);">
                            <p style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">{{ $campaign->donations->count() }}</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Backers</p>
                        </div>
                        <div style="background: #f8fafc; padding: 1.5rem; border-radius: var(--radius-md); text-align: center; border: 1px solid var(--border);">
                            <p style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">{{ \Carbon\Carbon::parse($campaign->deadline)->diffInDays() }}</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Days Left</p>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('donations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                            <div class="form-group">
                                <label class="form-label">Support this project</label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--text-muted); font-size: 1.15rem;">$</span>
                                    <input type="number" name="amount" class="form-control" style="padding-left: 2.75rem; font-weight: 800; font-size: 1.25rem;" placeholder="0" min="1" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.5rem; font-size: 1.25rem; border-radius: var(--radius-md);">
                                Back this project <i data-lucide="heart" style="width: 20px;"></i>
                            </button>
                        </form>
                    @else
                        <div style="text-align: center; background: #f8fafc; padding: 3rem; border-radius: var(--radius-lg); border: 2px dashed var(--border);">
                            <i data-lucide="lock" style="width: 32px; color: var(--text-muted); margin-bottom: 1.5rem;"></i>
                            <p style="margin-bottom: 2rem; color: var(--text-muted); font-weight: 600; font-size: 1.1rem;">Sign in to join the community and support this project.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%;">Log in to Back</a>
                        </div>
                    @endauth

                    <div style="margin-top: 5rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i data-lucide="users" style="color: var(--primary); width: 24px;"></i> Recent Backers
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            @forelse($campaign->donations->take(5) as $donation)
                                <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.25rem; background: #fcfdfe; border-radius: var(--radius-md); border: 1px solid var(--border); transition: 0.2s;" onmouseover="this.style.borderColor='var(--primary-glow)'" onmouseout="this.style.borderColor='var(--border)'">
                                    <div style="width: 50px; height: 50px; border-radius: 14px; background: white; color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
                                        {{ substr($donation->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div style="flex-grow: 1;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                                            <p style="font-weight: 800; font-size: 1.05rem;">{{ $donation->user->name ?? 'Guest' }}</p>
                                            <span style="font-weight: 800; color: var(--secondary); font-size: 1.1rem;">${{ number_format($donation->amount) }}</span>
                                        </div>
                                        <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 3rem; color: var(--text-muted); font-style: italic; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border);">No backers yet. Be the first!</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
