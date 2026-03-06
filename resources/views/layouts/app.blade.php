<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TripExplorer — Powered by Trip.com API')</title>
    <meta name="description" content="@yield('meta_description', 'Search and book hotels, flights worldwide. Powered by Trip.com API integration.')">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef7ff',
                            100: '#d9edff',
                            200: '#bbe0ff',
                            300: '#8eccff',
                            400: '#5ab1ff',
                            500: '#3490fc',
                            600: '#1e70f1',
                            700: '#165ade',
                            800: '#1849b4',
                            900: '#1a3f8d',
                            950: '#152856'
                        },
                        accent: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75'
                        },
                        dark: {
                            800: '#1e1b2e',
                            850: '#181527',
                            900: '#110e1f',
                            950: '#0a0816'
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* Animated gradient background */
        .hero-gradient {
            background: linear-gradient(135deg, #0a0816 0%, #1a1035 25%, #152856 50%, #1a3f8d 75%, #1e1b2e 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(52, 144, 252, 0.15), 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        /* Shine effect on hover */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.05) 50%, transparent 70%);
            transform: translateX(-100%) rotate(0deg);
            transition: transform 0.7s ease;
        }

        .shine-effect:hover::after {
            transform: translateX(50%) rotate(0deg);
        }

        /* Pulse dot */
        .pulse-dot {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.5);
            }
        }

        /* Float animation */
        .float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Star rating */
        .star-filled {
            color: #fbbf24;
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #110e1f;
        }

        ::-webkit-scrollbar-thumb {
            background: #3490fc;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5ab1ff;
        }

        /* Input custom styles */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(52, 144, 252, 0.3);
        }

        /* Badge shine */
        .badge-gradient {
            background: linear-gradient(135deg, rgba(52, 144, 252, 0.2), rgba(217, 70, 239, 0.2));
        }

        /* Nav blur */
        .nav-blur {
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
        }
    </style>
    @yield('styles')
</head>

<body class="bg-dark-950 text-gray-100 min-h-screen antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 nav-blur bg-dark-950/70 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 transition-shadow">
                            <i data-lucide="globe" class="w-5 h-5 text-white"></i>
                        </div>
                        <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 rounded-full pulse-dot border-2 border-dark-950"></div>
                    </div>
                    <div>
                        <span class="text-lg font-bold bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">TripExplorer</span>
                        <span class="block text-[10px] text-gray-500 -mt-1 font-medium tracking-wider">TRIP.COM API</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('home') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="home" class="w-4 h-4"></i> Home</span>
                    </a>
                    <a href="{{ route('hotels.search') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('hotels.*') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="building-2" class="w-4 h-4"></i> Hotels</span>
                    </a>
                    <a href="{{ route('flights.search') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('flights.*') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4"></i> Flights</span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/5 bg-dark-950/95">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">Home</a>
                <a href="{{ route('hotels.search') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">Hotels</a>
                <a href="{{ route('flights.search') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">Flights</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-dark-950/80 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                            <i data-lucide="globe" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-lg font-bold text-white">TripExplorer</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                        A real-world Trip.com API integration demo built with Laravel & Tailwind CSS.
                        Search hotels & flights powered by the Trip.com Partner API.
                    </p>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 pulse-dot"></span>
                            API Connected
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium badge-gradient text-primary-300 border border-primary-500/20">
                            {{ config('tripcom.use_mock') ? 'Mock Mode' : 'Live API' }}
                        </span>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white mb-4">Explore</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('hotels.search') }}" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Search Hotels</a></li>
                        <li><a href="{{ route('flights.search') }}" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Search Flights</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white mb-4">Integration</h3>
                    <ul class="space-y-2.5">
                        <li><a href="https://www.trip.com/openplatform/" target="_blank" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Trip.com Open Platform</a></li>
                        <li><a href="https://laravel.com/docs" target="_blank" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Laravel Docs</a></li>
                        <li><a href="https://tailwindcss.com/docs" target="_blank" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Tailwind CSS</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">© {{ date('Y') }} TripExplorer — Trip.com API Integration Demo</p>
                <p class="text-xs text-gray-600">Built with Laravel {{ app()->version() }} + Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <!-- Lucide Icons Init -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Mobile menu toggle -->
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>

    @yield('scripts')
</body>

</html>