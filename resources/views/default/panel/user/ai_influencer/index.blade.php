@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Influencer'))
@section('titlebar_title')
    <span class="ai-influencer-page-title">
        {{ __('AI Influencer') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('Promote   products with engaging ads and videos.') }}
@endsection
@section('titlebar_actions')
    @if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('url-to-video'))
        <x-button
            href="#"
            x-data
            @click.prevent="$store.aiUrlToVideoData.toggleUrlToVideoWindow()"
        >
            <x-tabler-plus class="size-4" />
            @lang('Create Video')
        </x-button>
    @endif
@endsection

@push('css')
    <style>
        /* AI Influencer Page Background - Matching Dashboard Theme */
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
        #rocket-stars-ai-influencer {
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
        .ai-influencer-page-title {
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
            .ai-influencer-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .ai-influencer-page-title {
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
        
        /* Video Cards Styling */
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list > div > div,
        body[data-theme="marketing-bot-dashboard"] .influencer-video-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-ai-influencer"></div>
    
    <div class="py-10 relative z-10">
        <div
            class="lqd-external-chatbot-edit kkkkkkk"
            x-data="aiInflucencerData"
        >
            @include('panel.user.ai_influencer.home.actions-grid')
            @include('panel.user.ai_influencer.home.videos-list')
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for AI Influencer Page
        let aiInfluencerStars = [];
        let aiInfluencerMouseX = 0;
        let aiInfluencerMouseY = 0;
        
        function createAIInfluencerStars() {
            const starsContainer = document.getElementById('rocket-stars-ai-influencer');
            if (!starsContainer) return;
            
            const starCount = 100;
            aiInfluencerStars = [];
            
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
                aiInfluencerStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-ai-influencer');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                aiInfluencerMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                aiInfluencerMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateAIInfluencerStars();
            });
            
            // Initialize stars
            updateAIInfluencerStars();
        }
        
        function updateAIInfluencerStars() {
            aiInfluencerStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = aiInfluencerMouseX - starX;
                const dy = aiInfluencerMouseY - starY;
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
            createAIInfluencerStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createAIInfluencerStars);
        } else {
            createAIInfluencerStars();
        }
    </script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiInflucencerData', () => ({
                init() {
                    Alpine.store('aiInflucencerData', this);
                },
                // when open or close the window, change some neccessary css.
                toggleWindow(open = true) {
                    const topNoticeBar = document.querySelector('.top-notice-bar');
                    const navbar = document.querySelector('.lqd-navbar');
                    const pageContentWrap = document.querySelector('.lqd-page-content-wrap');
                    const navbarExpander = document.querySelector('.lqd-navbar-expander');

                    document.documentElement.style.overflow = open ? 'hidden' : '';

                    if (window.innerWidth >= 992) {

                        if (navbar) {
                            navbar.style.position = open ? 'fixed' : '';
                        }

                        if (pageContentWrap) {
                            pageContentWrap.style.paddingInlineStart = open ?
                                'var(--navbar-width)' : '';
                        }

                        if (topNoticeBar) {
                            topNoticeBar.style.visibility = open ? 'hidden' :
                                '';
                        }

                        if (navbarExpander) {
                            navbarExpander.style.visibility = open ? 'hidden' :
                                '';
                            navbarExpander.style.opacity = open ? 0 : 1;
                        }
                    }
                }
            }))
        });
    </script>
@endpush
