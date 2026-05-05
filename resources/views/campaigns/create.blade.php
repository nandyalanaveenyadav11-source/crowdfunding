@extends('layouts.app-custom')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; background-color: white; border: 1px solid var(--border); padding: 4rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; text-align: center;">Start Your Campaign</h1>
        
        <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Campaign Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="What are you raising funds for?" required>
                @error('title') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="Technology">Technology</option>
                        <option value="Community">Community</option>
                        <option value="Education">Education</option>
                        <option value="Health">Health</option>
                        <option value="Environment">Environment</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="type">Crowdfunding Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="donation">Donation-based (No return)</option>
                        <option value="reward">Reward-based (Gifts/Products)</option>
                        <option value="equity">Equity-based (Shares)</option>
                        <option value="debt">Debt-based (Repaid later)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" rows="6" class="form-control" placeholder="Tell your story. Why should people donate?" required></textarea>
                @error('description') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="form-group">
                    <label class="form-label" for="goal_amount">Goal Amount ($)</label>
                    <input type="number" name="goal_amount" id="goal_amount" class="form-control" placeholder="e.g. 5000" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="deadline">Deadline</label>
                    <input type="date" name="deadline" id="deadline" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Campaign Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem;">Recommended size: 1200x800px. Max 2MB.</p>
            </div>

            <div class="form-group" id="reward-details-group" style="display: none;">
                <label class="form-label" for="reward_details">Reward Details (What will backers receive?)</label>
                <textarea name="reward_details" id="reward_details" rows="3" class="form-control" placeholder="e.g. Early access to product, signed posters, etc."></textarea>
            </div>

            <div class="form-group" id="equity-details-group" style="display: none;">
                <label class="form-label" for="equity_details">Equity Details (What shares/ownership are offered?)</label>
                <textarea name="equity_details" id="equity_details" rows="3" class="form-control" placeholder="e.g. 0.1% equity for every $1000 invested."></textarea>
            </div>

            <div class="form-group" id="repayment-details-group" style="display: none;">
                <label class="form-label" for="repayment_details">Repayment Details (When and how will it be repaid?)</label>
                <textarea name="repayment_details" id="repayment_details" rows="3" class="form-control" placeholder="e.g. Repaid within 12 months with 5% interest."></textarea>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Submit Campaign for Approval</button>
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
