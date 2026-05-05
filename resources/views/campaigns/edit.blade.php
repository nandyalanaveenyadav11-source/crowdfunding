@extends('layouts.app-custom')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="max-width: 800px; margin: 0 auto; background-color: white; border: 1px solid var(--border-color); padding: 3rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; text-align: center;">Edit Campaign</h1>
        
        <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="title">Campaign Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $campaign->title) }}" required>
                @error('title') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="Technology" {{ $campaign->category == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Community" {{ $campaign->category == 'Community' ? 'selected' : '' }}>Community</option>
                        <option value="Education" {{ $campaign->category == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Health" {{ $campaign->category == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Environment" {{ $campaign->category == 'Environment' ? 'selected' : '' }}>Environment</option>
                        <option value="Other" {{ $campaign->category == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="type">Crowdfunding Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="donation" {{ $campaign->type == 'donation' ? 'selected' : '' }}>Donation-based (No return)</option>
                        <option value="reward" {{ $campaign->type == 'reward' ? 'selected' : '' }}>Reward-based (Gifts/Products)</option>
                        <option value="equity" {{ $campaign->type == 'equity' ? 'selected' : '' }}>Equity-based (Shares)</option>
                        <option value="debt" {{ $campaign->type == 'debt' ? 'selected' : '' }}>Debt-based (Repaid later)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" rows="6" class="form-control" required>{{ old('description', $campaign->description) }}</textarea>
                @error('description') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="form-group">
                    <label class="form-label" for="goal_amount">Goal Amount ($)</label>
                    <input type="number" name="goal_amount" id="goal_amount" class="form-control" value="{{ old('goal_amount', $campaign->goal_amount) }}" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="deadline">Deadline</label>
                    <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', \Carbon\Carbon::parse($campaign->deadline)->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Campaign Image (Leave blank to keep current)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if($campaign->image)
                    <div style="margin-top: 1rem;">
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="Current Image" style="width: 100px; border-radius: 0.5rem;">
                    </div>
                @endif
            </div>

            <div class="form-group" id="reward-details-group" style="display: none;">
                <label class="form-label" for="reward_details">Reward Details</label>
                <textarea name="reward_details" id="reward_details" rows="3" class="form-control">{{ old('reward_details', $campaign->reward_details) }}</textarea>
            </div>

            <div class="form-group" id="equity-details-group" style="display: none;">
                <label class="form-label" for="equity_details">Equity Details</label>
                <textarea name="equity_details" id="equity_details" rows="3" class="form-control">{{ old('equity_details', $campaign->equity_details) }}</textarea>
            </div>

            <div class="form-group" id="repayment-details-group" style="display: none;">
                <label class="form-label" for="repayment_details">Repayment Details</label>
                <textarea name="repayment_details" id="repayment_details" rows="3" class="form-control">{{ old('repayment_details', $campaign->repayment_details) }}</textarea>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Update Campaign</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const rewardGroup = document.getElementById('reward-details-group');
        const equityGroup = document.getElementById('equity-details-group');
        const repaymentGroup = document.getElementById('repayment-details-group');

        function toggleDetails() {
            const type = typeSelect.value;
            rewardGroup.style.display = type === 'reward' ? 'block' : 'none';
            equityGroup.style.display = type === 'equity' ? 'block' : 'none';
            repaymentGroup.style.display = type === 'debt' ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleDetails);
        toggleDetails(); // Run on load
    });
</script>
@endsection
