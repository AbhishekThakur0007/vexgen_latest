@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Music'))
@section('titlebar_title')
    <span class="ai-music-page-title">
        {{ __('AI Music') }}
    </span>
@endsection
@section('titlebar_subtitle', __('You can generate songs based on your short description of the song you want.'))
@section('titlebar_actions', '')

@push('css')
    <style>
        /* AI Music Page Background - Matching Dashboard Theme */
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
        #rocket-stars-ai-music {
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
        .ai-music-page-title {
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
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .ai-music-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .ai-music-page-title {
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
        
        /* Override the light card styling for the main card */
        body[data-theme="marketing-bot-dashboard"] .lqd-ai-avatar-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-ai-avatar-card::before {
            background: linear-gradient(to right, transparent 0%, rgba(123, 47, 247, 0.2) 100%) !important;
        }
        
        /* Song Item Cards */
        body[data-theme="marketing-bot-dashboard"] .image-result {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .image-result:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground,
        body[data-theme="marketing-bot-dashboard"] h3,
        body[data-theme="marketing-bot-dashboard"] h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .text-foreground,
        body[data-theme="marketing-bot-dashboard"] p {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Modal Styling */
        body[data-theme="marketing-bot-dashboard"] .ai-avatar-videos-modal-backdrop {
            background: rgba(0, 0, 0, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .ai-avatar-videos-modal-video-wrap button {
            background: rgba(10, 14, 39, 0.9) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .ai-avatar-videos-modal-video-wrap button:hover {
            background: rgba(0, 212, 255, 0.3) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-ai-music"></div>
    
    <div class="py-10 relative z-10">
        <x-card
            class="lqd-ai-avatar-card relative mb-12 overflow-hidden bg-[#F4E3FD] shadow-[0_2px_2px_hsla(0,0%,0%,0.1)] dark:bg-primary/5 lg:before:absolute lg:before:end-0 lg:before:top-0 lg:before:z-0 lg:before:h-full lg:before:w-4/12 lg:before:bg-gradient-to-r lg:before:from-transparent lg:before:to-[#9A6EE3] dark:lg:before:to-primary/20"
            class:body="flex flex-wrap justify-between gap-y-6"
            variant="solid"
            size="none"
        >
            <div class="w-full self-center p-10 lg:w-6/12 lg:p-14">
                <h3 class="mb-8 leading-6">
                    @lang('You can generate songs based on your short description of the song you want.')
                </h3>
                <div class="flex flex-wrap items-center gap-2">
                    <x-button href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.ai-music.create')) }}">
                        <x-tabler-plus class="size-4" />
                        @lang('Create New Song')
                    </x-button>
                </div>
            </div>
            <div class="flex w-full self-end lg:w-6/12 lg:justify-end lg:pe-12">
                <figure>
                    <img
                        width="295"
                        height="218"
                        src="{{ custom_theme_url('/assets/img/misc/ai-avatar.png') }}"
                        alt="@lang('AI Music')"
                    >
                </figure>
            </div>
        </x-card>

        <div
            class="lqd-ai-videos-wrap"
            id="lqd-ai-videos-wrap"
        >
            <svg
                width="0"
                height="0"
            >
                <defs>
                    <linearGradient
                        id="loader-spinner-gradient"
                        x1="0.667969"
                        y1="6.10667"
                        x2="23.0413"
                        y2="25.84"
                        gradientUnits="userSpaceOnUse"
                    >
                        <stop stop-color="#82E2F4" />
                        <stop
                            offset="0.502"
                            stop-color="#8A8AED"
                        />
                        <stop
                            offset="1"
                            stop-color="#6977DE"
                        />
                    </linearGradient>
                </defs>
            </svg>

            @if (filled($list))
                <h3 class="mb-8">
                    @lang('My Songs')
                </h3>
            @else
                <h2 class="col-span-full flex items-center justify-center">
                    @lang('No songs found.')
                </h2>
            @endif

            <div id="videos-container">
                @include('ai-music::songs-list', ['list' => $list])
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for AI Music Page
        let aiMusicStars = [];
        let aiMusicMouseX = 0;
        let aiMusicMouseY = 0;
        
        function createAiMusicStars() {
            const starsContainer = document.getElementById('rocket-stars-ai-music');
            if (!starsContainer) return;
            
            const starCount = 100;
            aiMusicStars = [];
            
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
                aiMusicStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-ai-music');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                aiMusicMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                aiMusicMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateAiMusicStars();
            });
            
            // Initialize stars
            updateAiMusicStars();
        }
        
        function updateAiMusicStars() {
            aiMusicStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = aiMusicMouseX - starX;
                const dy = aiMusicMouseY - starY;
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
            createAiMusicStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createAiMusicStars);
        } else {
            createAiMusicStars();
        }
    </script>
@endpush
