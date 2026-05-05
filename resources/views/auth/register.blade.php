@extends('layouts.app-custom')

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="max-width: 450px; margin: 0 auto; background-color: white; border: 1px solid var(--border-color); padding: 3rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 2rem; text-align: center;">Join CrowdFund</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                @error('email') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                @error('password') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                @error('password_confirmation') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">Create Account</button>
            
            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--text-muted);">
                Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600;">Log in</a>
            </p>
        </form>
    </div>
</div>
@endsection
