<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    @if(Auth::user()->delete_requested)
        <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(16, 185, 129, 0.2); margin-top: 1rem;">
            <p style="font-weight: 700; font-size: 1.1rem;">✅ Deletion Request Pending</p>
            <p>Our administrator has received your request and is reviewing it. Your account will be closed soon.</p>
        </div>
    @else
        <div style="background: #fff5f5; border: 1px solid #feb2b2; padding: 2rem; border-radius: 1rem; margin-top: 2rem;">
            <p style="margin-bottom: 1.5rem; color: #c53030; font-weight: 600;">
                To request account deletion, please enter your password and click the button below. This will notify our administrator to close your account.
            </p>
            
            <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to request account deletion? Your request will be sent to the Admin.')">
                @csrf
                @method('delete')

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-weight: 700; margin-bottom: 0.5rem;">Confirm Your Password</label>
                    <input type="password" name="password" id="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.5rem;" placeholder="Enter your password to confirm">
                    @if($errors->userDeletion->has('password'))
                        <p style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <button type="submit" style="background: #e53e3e; color: white; padding: 1rem 2rem; border: none; border-radius: 0.5rem; font-weight: 800; cursor: pointer; width: 100%;">
                    SEND DELETION REQUEST TO ADMIN
                </button>
            </form>
        </div>
    @endif
</section>
