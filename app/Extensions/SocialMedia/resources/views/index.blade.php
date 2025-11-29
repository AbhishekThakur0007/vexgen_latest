@php
    use App\Extensions\SocialMedia\System\Enums\PlatformEnum;
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Social Media Suite'))
@section('subtitle', __('AI Social Media Suite'))

@section('titlebar_title')
    <span class="social-media-home-page-title">@lang('AI Social Media Suite')</span>
@endsection

@push('css')
    <style>
        body[data-theme="marketing-bot-dashboard"] {
            position: relative;
        }
        
        /* Page Background with Stars */
        .rocket-stars-social-media-home {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .rocket-stars-social-media-home .star {
            position: absolute;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: twinkle 3s ease-in-out infinite;
        }
        
        .rocket-stars-social-media-home .star::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.8) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1.5);
            }
        }
        
        /* Main Content Area */
        body[data-theme="marketing-bot-dashboard"] .py-10 {
            position: relative;
            z-index: 1;
        }
        
        /* Gradient Page Title */
        .social-media-home-page-title {
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 50%, #7b2ff7 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease-in-out infinite, text-glow-pulse 3s ease-in-out infinite;
            position: relative;
            text-shadow: 0 0 40px rgba(0, 212, 255, 0.5);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        
        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        @keyframes text-glow-pulse {
            0%, 100% {
                filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6)) 
                        drop-shadow(0 0 30px rgba(123, 47, 247, 0.4));
            }
            50% {
                filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.9)) 
                        drop-shadow(0 0 40px rgba(123, 47, 247, 0.6))
                        drop-shadow(0 0 20px rgba(0, 153, 255, 0.5));
            }
        }
        
        @keyframes twinkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }
        
        /* Banner Styling */
        body[data-theme="marketing-bot-dashboard"] .group[class*="bg-gradient-to-r"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .group[class*="bg-gradient-to-r"] h3 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* All Cards Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="lqd-social-media"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="lqd-social-media"]:hover {
            transform: translateY(-5px) scale(1.02) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25) !important;
        }
        
        /* Card Body */
        body[data-theme="marketing-bot-dashboard"] .lqd-card-body {
            background: transparent !important;
        }
        
        /* Headings */
        body[data-theme="marketing-bot-dashboard"] h3,
        body[data-theme="marketing-bot-dashboard"] h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] p,
        body[data-theme="marketing-bot-dashboard"] span,
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Buttons */
        body[data-theme="marketing-bot-dashboard"] .lqd-button,
        body[data-theme="marketing-bot-dashboard"] button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-button:hover,
        body[data-theme="marketing-bot-dashboard"] button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            color: rgba(0, 212, 255, 1) !important;
            box-shadow: 0 4px 20px rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Dropdowns */
        body[data-theme="marketing-bot-dashboard"] [role="menu"],
        body[data-theme="marketing-bot-dashboard"] [class*="dropdown"],
        body[data-theme="marketing-bot-dashboard"] [class*="menu"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Status Badges */
        body[data-theme="marketing-bot-dashboard"] [class*="status"],
        body[data-theme="marketing-bot-dashboard"] [class*="badge"],
        body[data-theme="marketing-bot-dashboard"] [class*="pill"] {
            background: rgba(0, 212, 255, 0.15) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(0, 212, 255, 0.9) !important;
        }
        
        /* Chart Container */
        body[data-theme="marketing-bot-dashboard"] #chart-published-posts {
            background: transparent !important;
        }
        
        /* ApexCharts Styling */
        body[data-theme="marketing-bot-dashboard"] .apexcharts-canvas,
        body[data-theme="marketing-bot-dashboard"] .apexcharts-svg {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .apexcharts-text,
        body[data-theme="marketing-bot-dashboard"] .apexcharts-legend-text {
            fill: rgba(255, 255, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .apexcharts-gridline {
            stroke: rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Platform Icons */
        body[data-theme="marketing-bot-dashboard"] figure img {
            filter: brightness(1.1);
        }
        
        /* Links */
        body[data-theme="marketing-bot-dashboard"] a {
            color: rgba(0, 212, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] a:hover {
            color: rgba(0, 212, 255, 1) !important;
        }
        
        /* Overview Cards Numbers */
        body[data-theme="marketing-bot-dashboard"] [class*="number-counter"],
        body[data-theme="marketing-bot-dashboard"] [class*="text-2xl"] {
            color: rgba(255, 255, 255, 0.95) !important;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Post Images */
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-post-img {
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 212, 255, 0.2);
        }
        
        /* Tools Grid */
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-tools-grid .lqd-card {
            text-align: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .social-media-home-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .social-media-home-page-title {
                font-size: 1.75rem;
            }
        }
    </style>
@endpush

@section('titlebar_actions')
    <x-button
        href="{{ route('dashboard.user.social-media.platforms') }}"
        variant="ghost-shadow"
    >
        @lang('Connect Accounts')
    </x-button>

    @include('social-media::components.create-post-dropdown', ['platforms' => $platforms])
@endsection

@section('content')
    <div class="rocket-stars-social-media-home" id="rocket-stars-social-media-home"></div>
    
    <div class="py-10">
        <div class="space-y-12">
            @include('social-media::components.home.banner')

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                @include('social-media::components.home.platform-cards', ['platforms' => $platforms])
                @include('social-media::components.home.published-posts-chart', ['platforms_published_posts' => $platforms_published_posts])
            </div>

            @include('social-media::components.home.overview-grid', ['posts_stats' => $posts_stats])

            @include('social-media::components.home.posts-grid', ['platforms' => $platforms, 'posts' => $posts])

            @include('social-media::components.home.accounts', ['platforms' => $platforms])

            @include('social-media::components.home.tools')
        </div>

        {{-- blade-formatter-disable --}}
        <svg class="absolute h-0 w-0" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" > <defs> <linearGradient id="social-posts-overview-gradient" x1="9.16667" y1="15.1507" x2="32.6556" y2="31.9835" gradientUnits="userSpaceOnUse" > <stop stop-color="hsl(var(--gradient-from))" /> <stop offset="0.502" stop-color="hsl(var(--gradient-via))" /> <stop offset="1" stop-color="hsl(var(--gradient-to))" /> </linearGradient> </defs> </svg>
		{{-- blade-formatter-enable --}}
    </div>
@endsection

@push('script')
    <script>
        function createSocialMediaHomeStars() {
            const container = document.getElementById('rocket-stars-social-media-home');
            if (!container) return;
            
            const starCount = 100;
            const stars = [];
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                
                const size = Math.random() * 3 + 1;
                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 3 + 's';
                star.style.animationDuration = (Math.random() * 3 + 2) + 's';
                
                container.appendChild(star);
                stars.push(star);
            }
            
            return stars;
        }
        
        function updateSocialMediaHomeStars() {
            const container = document.getElementById('rocket-stars-social-media-home');
            if (!container) return;
            
            const stars = container.querySelectorAll('.star');
            stars.forEach(star => {
                const newLeft = Math.random() * 100;
                const newTop = Math.random() * 100;
                star.style.transition = 'all 5s ease';
                star.style.left = newLeft + '%';
                star.style.top = newTop + '%';
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            createSocialMediaHomeStars();
            
            setInterval(updateSocialMediaHomeStars, 10000);
            
            document.addEventListener('mousemove', function(e) {
                const container = document.getElementById('rocket-stars-social-media-home');
                if (!container) return;
                
                const stars = container.querySelectorAll('.star');
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                stars.forEach((star, index) => {
                    const speed = (index % 5 + 1) * 0.5;
                    const x = (mouseX - 0.5) * speed;
                    const y = (mouseY - 0.5) * speed;
                    
                    star.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
        });
    </script>
@endpush
