@extends('panel.layout.app', [
    'disable_tblr' => true,
])

@section('title', __('AI Influencer Avatar'))
@section('titlebar_title')
    <span class="influencer-avatar-page-title">
        {{ __('AI Influencer Avatar') }}
    </span>
@endsection
@section('titlebar_subtitle', __('Generate captivating influencer video content for Reels, TikTok, and Shorts.'))
@section('titlebar_actions', '')

@push('css')
    <style>
        /* Influencer Avatar Page Background - Matching Chatbot Theme */
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
        #rocket-stars-influencer-avatar {
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
        .influencer-avatar-page-title {
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
            .influencer-avatar-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .influencer-avatar-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Action Card Styling - Modern Gradient Backgrounds */
        .influencer-action-card-wrapper {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .influencer-action-card-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .influencer-action-card-wrapper:hover::before {
            opacity: 1;
        }
        
        .influencer-action-card-wrapper:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Icon Container Styling */
        .influencer-icon-container {
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
            border: 2px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(123, 47, 247, 0.2);
            transition: all 0.3s ease;
        }
        
        .influencer-action-card-wrapper:hover .influencer-icon-container {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 0 40px rgba(0, 212, 255, 0.5), inset 0 0 30px rgba(123, 47, 247, 0.3);
        }
        
        /* Icon Wrapper Styling */
        .influencer-icon-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .influencer-icon {
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
        
        .icon-glow {
            filter: drop-shadow(0 0 15px rgba(0, 212, 255, 0.8));
        }
        
        /* Action Buttons Styling */
        .influencer-action-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        .influencer-action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }
        
        /* Video List Cards Styling */
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list .lqd-card,
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list [class*="card"],
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list .influencer-video-card,
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list > div > div {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Video Card Hover Effect */
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list .influencer-video-card:hover,
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list > div > div:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Video Background Styling */
        .influencer-videos-list .bg-foreground\/80 {
            background: rgba(10, 14, 39, 0.8) !important;
        }

        /* Video Card Content Styling */
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list h2,
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list h3 {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list p,
        body[data-theme="marketing-bot-dashboard"] .influencer-videos-list span {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Video List Heading */
        .influencer-videos-list h2 {
            color: transparent;
            background: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 50%, #00ff88 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease-in-out infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        /* Video Card Text */
        .influencer-videos-list .text-heading-foreground {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .influencer-videos-list .text-foreground {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Video Player Controls */
        .influencer-videos-list button,
        .influencer-videos-list .cursor-pointer {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        .influencer-videos-list button:hover,
        .influencer-videos-list .cursor-pointer:hover {
            color: rgba(0, 212, 255, 1) !important;
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-influencer-avatar"></div>
    
    <div class="py-10 relative z-10">
        <div
            class="lqd-external-chatbot-edit kkkkkkk"
            x-data="aiInflucencerData"
        >
            @include('influencer-avatar::home.actions-grid')
            @include('panel.user.ai_influencer.home.videos-list')
            @include('influencer-avatar::social-video-window.social-video-window', ['overlay' => false])
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Influencer Avatar Page
        let influencerAvatarStars = [];
        let influencerAvatarMouseX = 0;
        let influencerAvatarMouseY = 0;
        
        function createInfluencerAvatarStars() {
            const starsContainer = document.getElementById('rocket-stars-influencer-avatar');
            if (!starsContainer) return;
            
            const starCount = 100;
            influencerAvatarStars = [];
            
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
                influencerAvatarStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-influencer-avatar');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                influencerAvatarMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                influencerAvatarMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateInfluencerAvatarStars();
            });
            
            // Initialize stars
            updateInfluencerAvatarStars();
        }
        
        function updateInfluencerAvatarStars() {
            influencerAvatarStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = influencerAvatarMouseX - starX;
                const dy = influencerAvatarMouseY - starY;
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
            createInfluencerAvatarStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createInfluencerAvatarStars);
        } else {
            createInfluencerAvatarStars();
        }
    </script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiInflucencerData', () => ({
                influencerAvatarWindowKey: 0,
                init() {
                    Alpine.store('aiInflucencerData', this);
                    this.toggleWindow();
                },
                // when open or close the window, change some neccessary css.
                toggleWindow(open = true) {
                    Alpine.nextTick(() => {
                        this.influencerAvatarWindowKey = 1;
                    })

                    const topNoticeBar = document.querySelector('.top-notice-bar');
                    const navbar = document.querySelector('.lqd-navbar');
                    const pageContentWrap = document.querySelector('.lqd-page-content-wrap');
                    const navbarExpander = document.querySelector('.lqd-navbar-expander');

                    document.documentElement.style.overflow = open ? 'hidden' : '';

                    if (window.innerWidth >= 992) {

                        if (navbar) {
                            navbar.style.position = open ? 'fixed' : '';
                        }

                        if (pageContentWrap && navbar?.offsetWidth > 0) {
                            pageContentWrap.style.paddingInlineStart = open ? 'var(--navbar-width)' : '';
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
