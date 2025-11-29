@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('MarketingBot'))
@section('titlebar_title')
    <span class="marketing-bot-page-title">
        {{ __('MarketingBot') }}
    </span>
@endsection
@section('subtitle', __('MarketingBot'))
@section('titlebar_subtitle', __('Smart automations across WhatsApp, Telegram and more.'))
@section('titlebar_actions')
    <x-dropdown.dropdown
        anchor="end"
        offsetY="13px"
    >
        <x-slot:trigger
            variant="none"
        >
            @lang('View Campaigns')
        </x-slot:trigger>

        <x-slot:dropdown
            class="min-w-52 overflow-hidden p-2"
        >
            <x-button
                @class([
                    'w-full justify-start rounded-md px-3 py-2 text-start text-2xs hover:bg-heading-foreground/5 hover:no-underline',
                ])
                variant="link"
                href="{{ route('dashboard.user.marketing-bot.whatsapp-campaign.index') }}"
            >
                <img
                    class="h-auto w-6"
                    src="{{ asset('vendor/marketing-bot/images/whatsapp.png') }}"
                    alt="{{ 'whatsapp' }}"
                />
                WhatsApp
            </x-button>
            <x-button
                @class([
                    'w-full justify-start rounded-md px-3 py-2 text-start text-2xs hover:bg-heading-foreground/5 hover:no-underline',
                ])
                variant="link"
                href="{{ route('dashboard.user.marketing-bot.telegram-campaign.index') }}"
            >
                <img
                    class="h-auto w-6"
                    src="{{ asset('vendor/marketing-bot/images/telegram.png') }}"
                    alt="{{ 'telegram' }}"
                />
                Telegram
            </x-button>

        </x-slot:dropdown>
    </x-dropdown.dropdown>
    <x-dropdown.dropdown
        anchor="end"
        offsetY="13px"
    >
        <x-slot:trigger
            variant="primary"
        >
            <x-tabler-plus class="size-4" />
            @lang('Create New Campaign')
        </x-slot:trigger>

        <x-slot:dropdown
            class="min-w-52 overflow-hidden p-2"
        >
            <x-button
                @class([
                    'w-full justify-start rounded-md px-3 py-2 text-start text-2xs hover:bg-heading-foreground/5 hover:no-underline',
                ])
                variant="link"
                href="{{ route('dashboard.user.marketing-bot.whatsapp-campaign.create') }}"
            >
                <img
                    class="h-auto w-6"
                    src="{{ asset('vendor/marketing-bot/images/whatsapp.png') }}"
                    alt="{{ 'whatsapp' }}"
                />
                WhatsApp
            </x-button>
            <x-button
                @class([
                    'w-full justify-start rounded-md px-3 py-2 text-start text-2xs hover:bg-heading-foreground/5 hover:no-underline',
                ])
                variant="link"
                href="{{ route('dashboard.user.marketing-bot.telegram-campaign.create') }}"
            >
                <img
                    class="h-auto w-6"
                    src="{{ asset('vendor/marketing-bot/images/telegram.png') }}"
                    alt="{{ 'telegram' }}"
                />
                Telegram
            </x-button>

        </x-slot:dropdown>
    </x-dropdown.dropdown>
@endsection

@push('css')
    <style>
        /* Marketing Bot Page Background - Matching Dashboard Theme */
        body[data-theme="marketing-bot-dashboard"] .lqd-page-wrapper,
        body[data-theme="marketing-bot-dashboard"] {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1d3a 50%, #0f1729 100%) !important;
            min-height: 100vh;
        }
        
        /* Ensure content appears above stars */
        .lqd-page-wrapper > .lqd-page-container,
        .lqd-page-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Stars background positioning */
        #rocket-stars-marketing-bot {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        
        /* Unique Heading Styling - Gradient Text with Glow */
        .marketing-bot-page-title {
            display: inline-block;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 40%, #7b2ff7 100%);
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
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .marketing-bot-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .marketing-bot-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Card Body Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] .lqd-card [class*="body"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card-body {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
        }
        
        /* Card Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .text-foreground {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Banner Styling */
        body[data-theme="marketing-bot-dashboard"] [class*="banner"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
        }
        
        /* Chart Cards */
        body[data-theme="marketing-bot-dashboard"] [class*="chart"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
        }
        
        /* Modern Icon Container */
        .marketing-bot-icon-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%);
            border: 2px solid rgba(0, 212, 255, 0.3);
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(123, 47, 247, 0.2);
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .marketing-bot-icon-container:hover {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 0 40px rgba(0, 212, 255, 0.5), inset 0 0 30px rgba(123, 47, 247, 0.3);
        }
        
        .marketing-bot-modern-icon {
            width: 35px;
            height: 35px;
            filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6));
            animation: iconFloat 3s ease-in-out infinite;
        }
        
        @keyframes iconFloat {
            0%, 100% { 
                transform: translateY(0px) scale(1);
            }
            50% { 
                transform: translateY(-10px) scale(1.05);
            }
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-marketing-bot"></div>
    
    <div class="py-10 relative z-10">
        <div class="space-y-12">
            @include('marketing-bot::dashboard.components.banner')
        </div>

        <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
            @include('marketing-bot::dashboard.components.campaign-chart', ['data' => $chartCampaigns])
            @include('marketing-bot::dashboard.components.new-contact-chart', ['data' => $chartNewContacts])
        </div>

        @include('marketing-bot::dashboard.components.overview-grid', ['items' => $totals])
        @include('marketing-bot::dashboard.components.list')

        {{-- blade-formatter-disable --}}
        <svg class="absolute h-0 w-0" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" > <defs> <linearGradient id="social-posts-overview-gradient" x1="9.16667" y1="15.1507" x2="32.6556" y2="31.9835" gradientUnits="userSpaceOnUse" > <stop stop-color="hsl(var(--gradient-from))" /> <stop offset="0.502" stop-color="hsl(var(--gradient-via))" /> <stop offset="1" stop-color="hsl(var(--gradient-to))" /> </linearGradient> </defs> </svg>
		{{-- blade-formatter-enable --}}
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Marketing Bot Page
        let marketingBotStars = [];
        let marketingBotMouseX = 0;
        let marketingBotMouseY = 0;
        
        function createMarketingBotStars() {
            const starsContainer = document.getElementById('rocket-stars-marketing-bot');
            if (!starsContainer) return;
            
            const starCount = 100;
            marketingBotStars = [];
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'rocket-star interactive-dashboard-star';
                const size = Math.random() * 2 + 1;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 3;
                
                star.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: white;
                    border-radius: 50%;
                    left: ${x}%;
                    top: ${y}%;
                    opacity: ${Math.random() * 0.5 + 0.3};
                    box-shadow: 0 0 ${size * 2}px rgba(0, 212, 255, 0.6),
                                0 0 ${size * 4}px rgba(123, 47, 247, 0.4);
                    animation: twinkle ${duration}s ease-in-out infinite;
                    animation-delay: ${delay}s;
                    transition: all 0.3s ease;
                    pointer-events: none;
                `;
                
                star.dataset.x = x;
                star.dataset.y = y;
                star.dataset.baseOpacity = star.style.opacity;
                star.dataset.baseSize = size;
                
                starsContainer.appendChild(star);
                marketingBotStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-marketing-bot');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                marketingBotMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                marketingBotMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateMarketingBotStars();
            });
            
            // Initialize stars
            updateMarketingBotStars();
        }
        
        function updateMarketingBotStars() {
            marketingBotStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = marketingBotMouseX - starX;
                const dy = marketingBotMouseY - starY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                // Calculate intensity based on distance (closer = brighter)
                const maxDistance = 30;
                const intensity = Math.max(0, 1 - (distance / maxDistance));
                
                // Update star properties
                const baseOpacity = parseFloat(star.dataset.baseOpacity);
                const baseSize = parseFloat(star.dataset.baseSize);
                
                const newOpacity = Math.min(1, baseOpacity + intensity * 0.7);
                const newSize = baseSize + intensity * 2;
                const glowSize = newSize * 3;
                
                star.style.opacity = newOpacity;
                star.style.width = newSize + 'px';
                star.style.height = newSize + 'px';
                star.style.boxShadow = `
                    0 0 ${glowSize}px rgba(0, 212, 255, ${0.6 + intensity * 0.4}),
                    0 0 ${glowSize * 2}px rgba(123, 47, 247, ${0.4 + intensity * 0.3}),
                    0 0 ${glowSize * 3}px rgba(0, 255, 136, ${intensity * 0.2})
                `;
            });
        }
        
        // Initialize stars when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createMarketingBotStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createMarketingBotStars);
        } else {
            createMarketingBotStars();
        }
    </script>
    
    <script>
        $('[data-delete="delete"]').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this campaign?')) {
                return;
            }

            let deleteLink = $(this).data('delete-link');

            $.ajax({
                url: deleteLink,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr.success(data.message);

                        setTimeout(function() {
                            window.location.reload();
                        }, 600);

                        return;
                    }

                    if (data.message) {
                        toastr.error(data.message);
                        return;
                    }

                    toastr.error('Something went wrong!');
                },
                error: function(e) {
                    if (e?.responseJSON?.message) {
                        toastr.error(e.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>
@endpush
