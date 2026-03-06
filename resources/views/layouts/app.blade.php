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

    <!-- Leaflet Maps CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Leaflet Maps JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Fix Leaflet marker icon paths when using CDN
        if (typeof L !== 'undefined') {
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            });
        }
    </script>

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
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('home') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="home" class="w-4 h-4"></i> {{ __('messages.home') }}</span>
                    </a>
                    <a href="{{ route('hotels.search') }}" class="px-3 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('hotels.*') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="building-2" class="w-4 h-4"></i> {{ __('messages.hotels') }}</span>
                    </a>
                    <a href="{{ route('flights.search') }}" class="px-3 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs('flights.*') ? 'text-white bg-white/5' : '' }}">
                        <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4"></i> {{ __('messages.flights') }}</span>
                    </a>

                    <div class="h-6 w-px bg-white/10 mx-2"></div>

                    <!-- Language Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                            <i data-lucide="languages" class="w-4 h-4"></i>
                            <span class="uppercase">{{ app()->getLocale() }}</span>
                            <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                        </button>
                        <div class="absolute right-0 mt-1 w-32 glass rounded-xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 shadow-xl border border-white/10">
                            <a href="{{ route('locale.language', 'en') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ app()->getLocale() == 'en' ? 'bg-primary-500/10 text-primary-400' : '' }}">English</a>
                            <a href="{{ route('locale.language', 'es') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ app()->getLocale() == 'es' ? 'bg-primary-500/10 text-primary-400' : '' }}">Español</a>
                            <a href="{{ route('locale.language', 'ja') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ app()->getLocale() == 'ja' ? 'bg-primary-500/10 text-primary-400' : '' }}">日本語</a>
                        </div>
                    </div>

                    <!-- Currency Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                            <i data-lucide="coins" class="w-4 h-4"></i>
                            <span class="uppercase">{{ session('currency', 'USD') }}</span>
                            <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                        </button>
                        <div class="absolute right-0 mt-1 w-24 glass rounded-xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 shadow-xl border border-white/10">
                            <a href="{{ route('locale.currency', 'USD') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ session('currency', 'USD') == 'USD' ? 'bg-primary-500/10 text-primary-400' : '' }}">USD</a>
                            <a href="{{ route('locale.currency', 'EUR') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ session('currency', 'USD') == 'EUR' ? 'bg-primary-500/10 text-primary-400' : '' }}">EUR</a>
                            <a href="{{ route('locale.currency', 'JPY') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 {{ session('currency', 'USD') == 'JPY' ? 'bg-primary-500/10 text-primary-400' : '' }}">JPY</a>
                        </div>
                    </div>
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
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ __('messages.home') }}</a>
                <a href="{{ route('hotels.search') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ __('messages.hotels') }}</a>
                <a href="{{ route('flights.search') }}" class="block px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ __('messages.flights') }}</a>

                <div class="border-t border-white/10 my-2"></div>

                <div class="grid grid-cols-2 gap-2 text-center text-sm">
                    <a href="{{ route('locale.language', 'en') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ app()->getLocale() == 'en' ? 'bg-primary-500/10 text-primary-400' : '' }}">English</a>
                    <a href="{{ route('locale.language', 'es') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ app()->getLocale() == 'es' ? 'bg-primary-500/10 text-primary-400' : '' }}">Español</a>
                    <a href="{{ route('locale.language', 'ja') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ app()->getLocale() == 'ja' ? 'bg-primary-500/10 text-primary-400' : '' }}">日本語</a>
                </div>

                <div class="border-t border-white/10 my-2"></div>

                <div class="grid grid-cols-3 gap-2 text-center text-sm">
                    <a href="{{ route('locale.currency', 'USD') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ session('currency', 'USD') == 'USD' ? 'bg-primary-500/10 text-primary-400' : '' }}">USD</a>
                    <a href="{{ route('locale.currency', 'EUR') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ session('currency', 'USD') == 'EUR' ? 'bg-primary-500/10 text-primary-400' : '' }}">EUR</a>
                    <a href="{{ route('locale.currency', 'JPY') }}" class="py-2.5 rounded-xl text-gray-300 hover:bg-white/5 {{ session('currency', 'USD') == 'JPY' ? 'bg-primary-500/10 text-primary-400' : '' }}">JPY</a>
                </div>
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
                    <h3 class="text-sm font-semibold text-white mb-4">{{ __('messages.explore') }}</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('hotels.search') }}" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">{{ __('messages.search_hotels') }}</a></li>
                        <li><a href="{{ route('flights.search') }}" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">{{ __('messages.search_flights') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white mb-4">{{ __('messages.integration') }}</h3>
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

    <!-- AI Chat Widget -->
    <div id="chat-widget" class="fixed bottom-6 right-6 z-[100]">
        <!-- Chat Toggle Button -->
        <button id="chat-toggle" onclick="toggleChat()" class="h-14 px-6 rounded-full bg-gradient-to-br from-primary-600 to-accent-600 flex items-center gap-3 shadow-lg shadow-primary-600/30 hover:shadow-primary-500/50 transition-all hover:-translate-y-1 group relative chat-glow-pulse">
            <div class="relative flex items-center justify-center">
                <i data-lucide="bot" class="w-6 h-6 text-white chat-icon-open"></i>
                <i data-lucide="x" class="w-6 h-6 text-white chat-icon-close hidden"></i>
            </div>
            <span class="text-white font-medium text-sm chat-text-open">Chat with AI</span>
            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-dark-950"></span>
            </span>
        </button>

        <!-- Chat Panel -->
        <div id="chat-panel" class="hidden absolute bottom-20 right-0 w-[380px] max-h-[520px] glass rounded-2xl overflow-hidden shadow-2xl shadow-black/40 flex flex-col border border-white/10" style="display:none;">
            <!-- Chat Header -->
            <div class="flex items-center justify-between p-4 border-b border-white/5 bg-dark-900/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-md">
                        <i data-lucide="bot" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">TripExplorer AI</div>
                        <div class="text-[10px] text-green-400 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span> Online
                        </div>
                    </div>
                </div>
                <button onclick="clearChat()" class="p-1.5 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-all" title="Clear chat">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3" style="max-height: 340px; min-height: 280px;">
                <!-- Welcome message -->
                <div class="flex gap-2.5 chat-msg-bot">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="bot" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div class="bg-white/5 rounded-2xl rounded-tl-md px-4 py-2.5 max-w-[85%]">
                        <p class="text-sm text-gray-200 leading-relaxed">Hello! 👋 I'm your TripExplorer AI assistant. I can help you find hotels, flights, and the best deals across Asia. What are you looking for?</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex flex-wrap gap-1.5 pl-9" id="quick-actions">
                    <button onclick="sendQuickMsg('Show me hotels in Tokyo')" class="px-3 py-1.5 rounded-full bg-primary-500/10 border border-primary-500/20 text-xs font-medium text-primary-400 hover:bg-primary-500/20 transition-all">🏨 Hotels in Tokyo</button>
                    <button onclick="sendQuickMsg('Find cheap flights')" class="px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-xs font-medium text-blue-400 hover:bg-blue-500/20 transition-all">✈️ Cheap flights</button>
                    <button onclick="sendQuickMsg('Show me coupon codes')" class="px-3 py-1.5 rounded-full bg-green-500/10 border border-green-500/20 text-xs font-medium text-green-400 hover:bg-green-500/20 transition-all">🎟️ Coupons</button>
                    <button onclick="sendQuickMsg('Trip packages')" class="px-3 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-xs font-medium text-purple-400 hover:bg-purple-500/20 transition-all">📦 Packages</button>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-3 border-t border-white/5 bg-dark-900/30">
                <form id="chat-form" onsubmit="sendMessage(event)" class="flex gap-2">
                    <input type="text" id="chat-input" placeholder="Ask about hotels, flights..." autocomplete="off"
                        class="flex-1 bg-white/5 border border-white/10 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                    <button type="submit" id="chat-send-btn" class="px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white rounded-xl transition-all shadow-lg shadow-primary-600/25 flex-shrink-0">
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
                <p class="text-[10px] text-gray-600 text-center mt-1.5">Powered by {{ config('chatbot.api_key') ? 'Gemini AI' : 'Smart Travel Engine' }}</p>
            </div>
        </div>
    </div>

    <style>
        /* Chat widget animations */
        #chat-panel {
            animation: chatSlideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes chatSlideUp {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .chat-msg-bot,
        .chat-msg-user {
            animation: msgFadeIn 0.3s ease-out;
        }

        @keyframes msgFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Chat Widget Glow */
        .chat-glow-pulse {
            animation: chatGlowPulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes chatGlowPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(52, 144, 252, 0.4);
            }

            50% {
                box-shadow: 0 0 0 15px rgba(52, 144, 252, 0);
            }
        }

        /* Typing indicator */
        .typing-dot {
            animation: typingBounce 1.4s ease-in-out infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-4px);
            }
        }

        #chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: rgba(52, 144, 252, 0.3);
            border-radius: 2px;
        }

        @media (max-width: 450px) {
            #chat-panel {
                width: calc(100vw - 32px);
                right: -8px;
            }
        }
    </style>

    <!-- Chat Widget Script -->
    <script>
        let chatOpen = false;

        function toggleChat() {
            chatOpen = !chatOpen;
            const panel = document.getElementById('chat-panel');
            const openIcon = document.querySelector('.chat-icon-open');
            const closeIcon = document.querySelector('.chat-icon-close');
            const openText = document.querySelector('.chat-text-open');

            if (chatOpen) {
                panel.style.display = 'flex';
                panel.classList.remove('hidden');
                openIcon.classList.add('hidden');
                if (openText) openText.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                document.getElementById('chat-input').focus();
                scrollChat();
            } else {
                panel.style.display = 'none';
                panel.classList.add('hidden');
                openIcon.classList.remove('hidden');
                if (openText) openText.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
            lucide.createIcons();
        }

        function scrollChat() {
            const container = document.getElementById('chat-messages');
            setTimeout(() => container.scrollTop = container.scrollHeight, 50);
        }

        function formatMessage(text) {
            // Bold: **text**
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong class="text-white font-semibold">$1</strong>');
            // Newlines to <br>
            text = text.replace(/\n/g, '<br>');
            // Bullet points
            text = text.replace(/• /g, '<span class="text-primary-400">•</span> ');
            return text;
        }

        function addMessage(content, isUser) {
            const container = document.getElementById('chat-messages');
            // Remove quick actions after first message
            const qa = document.getElementById('quick-actions');
            if (qa) qa.remove();

            const div = document.createElement('div');
            div.className = isUser ?
                'flex gap-2.5 justify-end chat-msg-user' :
                'flex gap-2.5 chat-msg-bot';

            if (isUser) {
                div.innerHTML = `
                    <div class="bg-primary-600/20 border border-primary-500/20 rounded-2xl rounded-tr-md px-4 py-2.5 max-w-[85%]">
                        <p class="text-sm text-gray-200 leading-relaxed">${formatMessage(content)}</p>
                    </div>`;
            } else {
                div.innerHTML = `
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="bot" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div class="bg-white/5 rounded-2xl rounded-tl-md px-4 py-2.5 max-w-[85%]">
                        <p class="text-sm text-gray-200 leading-relaxed">${formatMessage(content)}</p>
                    </div>`;
            }

            container.appendChild(div);
            lucide.createIcons();
            scrollChat();
        }

        function showTyping() {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.id = 'typing-indicator';
            div.className = 'flex gap-2.5 chat-msg-bot';
            div.innerHTML = `
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i data-lucide="bot" class="w-3.5 h-3.5 text-white"></i>
                </div>
                <div class="bg-white/5 rounded-2xl rounded-tl-md px-4 py-3">
                    <div class="flex gap-1">
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                    </div>
                </div>`;
            container.appendChild(div);
            lucide.createIcons();
            scrollChat();
        }

        function removeTyping() {
            document.getElementById('typing-indicator')?.remove();
        }

        async function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const msg = input.value.trim();
            if (!msg) return;

            input.value = '';
            addMessage(msg, true);
            showTyping();

            // Disable input while waiting
            input.disabled = true;
            document.getElementById('chat-send-btn').disabled = true;

            try {
                const res = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        message: msg
                    }),
                });

                const data = await res.json();
                removeTyping();
                addMessage(data.reply, false);
            } catch (err) {
                removeTyping();
                addMessage('Sorry, something went wrong. Please try again!', false);
            }

            input.disabled = false;
            document.getElementById('chat-send-btn').disabled = false;
            input.focus();
        }

        function sendQuickMsg(msg) {
            document.getElementById('chat-input').value = msg;
            sendMessage(new Event('submit'));
        }

        async function clearChat() {
            try {
                await fetch('{{ route("chat.clear") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });
            } catch (e) {}

            const container = document.getElementById('chat-messages');
            container.innerHTML = `
                <div class="flex gap-2.5 chat-msg-bot">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="bot" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div class="bg-white/5 rounded-2xl rounded-tl-md px-4 py-2.5 max-w-[85%]">
                        <p class="text-sm text-gray-200 leading-relaxed">Chat cleared! 🔄 How can I help you? Ask me about hotels, flights, or travel deals.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-1.5 pl-9" id="quick-actions">
                    <button onclick="sendQuickMsg('Show me hotels in Tokyo')" class="px-3 py-1.5 rounded-full bg-primary-500/10 border border-primary-500/20 text-xs font-medium text-primary-400 hover:bg-primary-500/20 transition-all">🏨 Hotels in Tokyo</button>
                    <button onclick="sendQuickMsg('Find cheap flights')" class="px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-xs font-medium text-blue-400 hover:bg-blue-500/20 transition-all">✈️ Cheap flights</button>
                    <button onclick="sendQuickMsg('Show me coupon codes')" class="px-3 py-1.5 rounded-full bg-green-500/10 border border-green-500/20 text-xs font-medium text-green-400 hover:bg-green-500/20 transition-all">🎟️ Coupons</button>
                    <button onclick="sendQuickMsg('Trip packages')" class="px-3 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-xs font-medium text-purple-400 hover:bg-purple-500/20 transition-all">📦 Packages</button>
                </div>`;
            lucide.createIcons();
        }
    </script>

    @yield('scripts')
</body>

</html>