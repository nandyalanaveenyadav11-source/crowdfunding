<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CrowdFund') }} | Raise Funds for Your Dreams</title>

    <!-- Custom CSS -->
    <!-- Custom CSS (Embedded for Maximum Reliability) -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #6366f1;
            --primary-dark: #4338ca;
            --primary-glow: rgba(99, 102, 241, 0.4);
            --secondary: #10b981;
            --secondary-dark: #059669;
            --accent: #f43f5e;
            --bg-main: #f8fafc;
            --bg-mesh: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.05) 0, transparent 50%), 
                       radial-gradient(at 50% 0%, rgba(16, 185, 129, 0.05) 0, transparent 50%),
                       radial-gradient(at 100% 0%, rgba(244, 63, 94, 0.05) 0, transparent 50%);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: rgba(226, 232, 240, 0.8);
            --radius-sm: 0.75rem;
            --radius-md: 1rem;
            --radius-lg: 1.5rem;
            --radius-xl: 2.5rem;
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-primary: 0 10px 20px -5px var(--primary-glow);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background-color: var(--bg-main); background-image: var(--bg-mesh); color: var(--text-main); line-height: 1.6; min-height: 100vh; }
        .container { max-width: 1550px; margin: 0 auto; padding: 0 3rem; }
        a { text-decoration: none !important; color: inherit; }
        .navbar { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); padding: 1.25rem 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .nav-logo { font-size: 1.85rem; font-weight: 800; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.05em; text-decoration: none !important; }
        .nav-links { display: flex; gap: 3rem; align-items: center; }
        .nav-link { font-weight: 700; color: #475569; font-size: 0.95rem; transition: var(--transition); text-decoration: none !important; }
        .nav-link:hover { color: var(--primary); }
        .dashboard-layout { display: grid; grid-template-columns: 280px 1fr; gap: 3rem; padding: 2rem 0; }
        .sidebar { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(10px); border-radius: var(--radius-lg); padding: 1.5rem; height: fit-content; border: 1px solid var(--border); position: sticky; top: 100px; }
        .sidebar-link { display: flex; align-items: center; gap: 1rem; padding: 0.875rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 0.5rem; font-weight: 600; color: var(--text-muted); transition: var(--transition); }
        .sidebar-link:hover { background: rgba(99, 102, 241, 0.05); color: var(--primary); transform: translateX(5px); }
        .sidebar-link.active { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; box-shadow: var(--shadow-primary); }
        .sidebar-title { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 1.5rem 0 0.75rem 1.25rem; }
        .card { background: white; border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; transition: var(--transition); height: 100%; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-color: rgba(99, 102, 241, 0.2); }
        .card-img { width: 100%; height: 220px; object-fit: cover; }
        .card-body { padding: 2rem; flex-grow: 1; }
        .card-category { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); margin-bottom: 0.75rem; }
        .card-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
        .stat-card { padding: 2.5rem; border-radius: var(--radius-lg); color: white; position: relative; overflow: hidden; }
        .stat-card.grad-primary { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); }
        .stat-card.grad-secondary { background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); }
        .stat-card.grad-accent { background: linear-gradient(135deg, #f43f5e 0%, #fb923c 100%); }
        .stat-value { font-size: 3rem; font-weight: 800; line-height: 1; }
        .stat-label { font-size: 0.875rem; font-weight: 700; text-transform: uppercase; opacity: 0.8; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.875rem 2rem; border-radius: var(--radius-md); font-weight: 700; cursor: pointer; transition: var(--transition); border: none; gap: 0.75rem; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; box-shadow: var(--shadow-primary); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 30px -5px var(--primary-glow); }
        .btn-outline { background: white; border: 2px solid var(--border); color: var(--text-main); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: rgba(99, 102, 241, 0.02); }
        .btn-danger { background: linear-gradient(135deg, #f43f5e, #e11d48); color: white; }
        .btn-danger:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(244, 63, 94, 0.4); }
        .btn-secondary { background: #f1f5f9; color: #475569; }
        .form-card { background: white; border-radius: var(--radius-lg); padding: 3rem; border: 1px solid var(--border); }
        .form-group { margin-bottom: 2rem; }
        .form-label { display: block; font-weight: 800; font-size: 0.875rem; margin-bottom: 0.75rem; color: #1e293b; text-transform: uppercase; letter-spacing: 0.05em; }
        .form-control { width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; transition: var(--transition); }
        .form-control:focus { outline: none; border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .progress-container { background: #e2e8f0; height: 0.75rem; border-radius: 99px; margin-bottom: 1rem; overflow: hidden; }
        .progress-bar { background: linear-gradient(90deg, var(--primary), var(--secondary)); height: 100%; border-radius: 99px; transition: width 1s ease-in-out; }
        .badge { padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-pending { background: #fff7ed; color: #ea580c; }
        .badge-approved { background: #f0fdf4; color: #16a34a; }
        .badge-rejected { background: #fef2f2; color: #dc2626; }
        .grid-main { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .hero { padding: 8rem 0 12rem; text-align: center; background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%); position: relative; overflow: hidden; }
        .hero h1 { font-size: 5rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.05em; margin-bottom: 2rem; color: #0f172a; }
        .hero p { font-size: 1.5rem; color: #64748b; max-width: 800px; margin: 0 auto 4rem; }
        .search-wrapper { max-width: 750px; margin: 0 auto; position: relative; z-index: 10; }
        .search-input { width: 100%; padding: 1.5rem 5rem 1.5rem 2.5rem; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 99px; background: white; font-size: 1.1rem; font-weight: 600; box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.08); transition: var(--transition); color: #1e293b; }
        .search-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 25px 60px -12px rgba(99, 102, 241, 0.2); transform: translateY(-3px); }
        .search-input::placeholder { color: #94a3b8; font-weight: 500; }
        footer { background: #0f172a; padding: 5rem 0 3rem; color: white; margin-top: 5rem; }
        .scrolled { padding: 0.75rem 0; background: rgba(255, 255, 255, 0.95); }
    </style>
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
