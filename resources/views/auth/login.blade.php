@extends('layouts.app-custom')

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="max-width: 450px; margin: 0 auto; background-color: white; border: 1px solid var(--border-color); padding: 3rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 2rem; text-align: center;">Welcome Back</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                @error('password') <span style="color: var(--error-color); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <!-- Remember Me -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; font-size: 0.875rem; color: var(--text-muted);">
                    <input type="checkbox" name="remember" style="margin-right: 0.5rem;"> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--primary-color);">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">Log in</button>
            
            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--text-muted);">
                Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600;">Sign up</a>
            </p>
        </form>
    </div>
</div>
@endsection
