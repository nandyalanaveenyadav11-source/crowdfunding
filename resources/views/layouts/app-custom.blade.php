<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CrowdFund') }} | Raise Funds for Your Dreams</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="animate-fade-in">
    <header class="navbar" id="main-navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="nav-logo">CrowdFund</a>
            <nav class="nav-links">
                <a href="{{ route('campaigns.index') }}" class="nav-link">Explore</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link">My Dashboard</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: var(--accent); font-weight: 800;">
                            <i data-lucide="shield-check" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 4px;"></i> Admin Panel
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding: 0.6rem 1.5rem; border-radius: 99px;">
                            <i data-lucide="log-out" style="width: 18px; height: 18px;"></i> Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="border-radius: 99px;">
                        Get Started <i data-lucide="rocket" style="width: 18px; height: 18px;"></i>
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="container animate-fade-in" style="margin-top: 2rem;">
                <div style="background: rgba(16, 185, 129, 0.05); color: #065f46; padding: 1.25rem 2rem; border-radius: var(--radius-lg); border: 1px solid rgba(16, 185, 129, 0.2); backdrop-filter: blur(10px); display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="background: var(--secondary); color: white; padding: 0.5rem; border-radius: 50%; display: flex;">
                            <i data-lucide="check" style="width: 20px; height: 20px;"></i>
                        </div>
                        <span style="font-weight: 700; font-size: 1.05rem;">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: inherit; opacity: 0.5; transition: 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5">&times;</button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container animate-fade-in" style="margin-top: 2rem;">
                <div style="background: rgba(244, 63, 94, 0.05); color: #991b1b; padding: 1.25rem 2rem; border-radius: var(--radius-lg); border: 1px solid rgba(244, 63, 94, 0.2); backdrop-filter: blur(10px); display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="background: var(--accent); color: white; padding: 0.5rem; border-radius: 50%; display: flex;">
                            <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                        </div>
                        <span style="font-weight: 700; font-size: 1.05rem;">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: inherit; opacity: 0.5; transition: 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5">&times;</button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 6rem; margin-bottom: 5rem;">
                <div>
                    <a href="{{ url('/') }}" class="nav-logo" style="margin-bottom: 2rem; display: block;">CrowdFund</a>
                    <p style="max-width: 350px; line-height: 1.9; font-size: 1.1rem; color: #94a3b8;">Empowering creators, entrepreneurs, and dreamers to bring their ideas to life through community-driven funding.</p>
                </div>
                <div>
                    <h4 style="font-weight: 800; font-size: 1.15rem; margin-bottom: 2rem; color: white;">Explore</h4>
                    <ul style="display: flex; flex-direction: column; gap: 1rem;">
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">Technology</a></li>
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">Arts & Culture</a></li>
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">Social Good</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="font-weight: 800; font-size: 1.15rem; margin-bottom: 2rem; color: white;">Company</h4>
                    <ul style="display: flex; flex-direction: column; gap: 1rem;">
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">About Us</a></li>
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">Trust & Safety</a></li>
                        <li><a href="#" class="nav-link" style="color: #64748b; font-size: 1.05rem;">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="font-weight: 800; font-size: 1.15rem; margin-bottom: 2rem; color: white;">Connect</h4>
                    <div style="display: flex; gap: 1.5rem;">
                        <a href="#" style="color: #64748b; transition: 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748b'"><i data-lucide="twitter"></i></a>
                        <a href="#" style="color: #64748b; transition: 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748b'"><i data-lucide="instagram"></i></a>
                        <a href="#" style="color: #64748b; transition: 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748b'"><i data-lucide="github"></i></a>
                    </div>
                </div>
            </div>
            <div style="padding-top: 3rem; border-top: 1px solid #1e293b; text-align: center; color: #475569; font-size: 1rem;">
                <p>&copy; {{ date('Y') }} CrowdFund Platform. Precision engineered for impact.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
