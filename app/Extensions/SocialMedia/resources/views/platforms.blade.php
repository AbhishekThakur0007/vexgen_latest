@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Social Media Accounts'))
@section('titlebar_title')
    <span class="social-platforms-page-title">
        {{ __('Social Media Accounts') }}
    </span>
@endsection
@section('titlebar_actions', '')
@section('titlebar_subtitle', __('You can connect and manage multiple social media accounts from here.'))

@push('css')
    <style>
        /* Social Platforms Page Background - Matching Dashboard Theme */
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
        #rocket-stars-social-platforms {
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
        .social-platforms-page-title {
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
            .social-platforms-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .social-platforms-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Statistics Card - Summary Card */
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-cards-grid ~ [class*="card"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="mb-9"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] .lqd-card:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid:hover {
            transform: translateY(-2px);
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Statistics Card Body */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid .lqd-card-body {
            background: transparent !important;
        }
        
        /* Summary Heading */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] p[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid p[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] p[class*="text-xl"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid p[class*="text-xl"] {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }
        
        /* Statistics Links Container */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a {
            color: rgba(255, 255, 255, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            transition: all 0.3s ease !important;
            border-radius: 0.75rem !important;
            padding: 1rem !important;
            margin: 0.25rem !important;
            position: relative;
            overflow: hidden;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a::before,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover {
            color: rgba(0, 212, 255, 1) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(123, 47, 247, 0.1)) !important;
            transform: translateX(5px) translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 212, 255, 0.3) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover::before,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover::before {
            left: 100%;
        }
        
        /* Statistics Link Labels */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a span:first-child,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a span:first-child {
            color: rgba(255, 255, 255, 0.7) !important;
            transition: all 0.3s ease !important;
            font-size: 0.875rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover span:first-child,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover span:first-child {
            color: rgba(0, 212, 255, 1) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Statistics Numbers */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a span[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a span[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a span[class*="text-\[23px\]"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a span[class*="text-\[23px\]"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a span[class*="font-semibold"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a span[class*="font-semibold"] {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 700 !important;
            font-size: 1.75rem !important;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.4) !important;
            transition: all 0.3s ease !important;
            display: inline-block;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 0.25rem 0;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover span[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover span[class*="font-heading"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover span[class*="text-\[23px\]"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover span[class*="text-\[23px\]"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover span[class*="font-semibold"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover span[class*="font-semibold"] {
            background: linear-gradient(135deg, #00d4ff, #0099ff, #7b2ff7) !important;
            background-size: 200% auto !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            animation: gradient-shift 2s ease-in-out infinite !important;
            transform: scale(1.1);
            text-shadow: 0 0 30px rgba(0, 212, 255, 0.8) !important;
        }
        
        /* Chevron Icons */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a svg,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a svg {
            color: rgba(0, 212, 255, 0.8) !important;
            transition: all 0.3s ease !important;
            stroke-width: 2 !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover svg,
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover svg {
            color: rgba(0, 212, 255, 1) !important;
            transform: translateX(5px);
            filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.8));
        }
        
        /* Borders between statistics items */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a[class*="border-e"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a[class*="border-e"],
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a[class*="border-b"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a[class*="border-b"] {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover[class*="border-e"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover[class*="border-e"] {
            border-color: rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Remove underline on hover for better look */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-statistics"] a:hover span[class*="group-hover:underline"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card.lqd-card-solid a:hover span[class*="group-hover:underline"] {
            text-decoration: none !important;
        }
        
        /* Platform Cards */
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-card,
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-cards-grid .lqd-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-card:hover {
            transform: translateY(-5px) scale(1.02) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-card h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-card a {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-card a:hover {
            color: rgba(0, 212, 255, 1) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Platform Table */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] .lqd-social-posts-head,
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] [class*="posts-head"] {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] .lqd-social-media-posts-list > div,
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] [class*="posts-item"] {
            background: rgba(10, 14, 39, 0.6) !important;
            border-color: rgba(0, 212, 255, 0.15) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] .lqd-social-media-posts-list > div:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table"] [class*="posts-item"]:hover {
            background: rgba(0, 212, 255, 0.1) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2), 
                        0 0 10px rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Table Search */
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table-search"] input,
        body[data-theme="marketing-bot-dashboard"] [class*="table-search"] input,
        body[data-theme="marketing-bot-dashboard"] .header-search-input,
        body[data-theme="marketing-bot-dashboard"] [class*="header-search"] input {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.25) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border-radius: 0.5rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table-search"] input:focus,
        body[data-theme="marketing-bot-dashboard"] [class*="table-search"] input:focus,
        body[data-theme="marketing-bot-dashboard"] .header-search-input:focus,
        body[data-theme="marketing-bot-dashboard"] [class*="header-search"] input:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3) !important;
            background: rgba(10, 14, 39, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="platform-table-search"] input::placeholder,
        body[data-theme="marketing-bot-dashboard"] [class*="table-search"] input::placeholder,
        body[data-theme="marketing-bot-dashboard"] .header-search-input::placeholder,
        body[data-theme="marketing-bot-dashboard"] [class*="header-search"] input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="header-search"] [class*="bg-white"],
        body[data-theme="marketing-bot-dashboard"] [class*="header-search"] [class*="dark:bg-zinc-800"] {
            background: rgba(10, 14, 39, 0.9) !important;
        }
        
        /* Table Item Content */
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-content,
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-date {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Status Badges in Table */
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-type {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Action Buttons in Table */
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-actions button,
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-actions a {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-actions button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-actions a:hover {
            color: rgba(0, 212, 255, 1) !important;
            transform: translateY(-2px);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Headings */
        body[data-theme="marketing-bot-dashboard"] h3,
        body[data-theme="marketing-bot-dashboard"] h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] p,
        body[data-theme="marketing-bot-dashboard"] [class*="text-heading-foreground"] {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Buttons */
        body[data-theme="marketing-bot-dashboard"] button,
        body[data-theme="marketing-bot-dashboard"] .lqd-button {
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-social-platforms"></div>
    
    <div class="py-10 relative z-10">
	<div class="py-10">
		@include('social-media::platforms.platform-statistics', ['items' => $userPlatforms])
		@include('social-media::platforms.platform-cards', ['platforms' => $platforms])
		@include('social-media::platforms.platform-table', ['items' => $userPlatforms])
	</div>
@endsection
@push('script')
    <script>
        // Interactive Stars Background for Social Platforms Page
        let socialPlatformsStars = [];
        let socialPlatformsMouseX = 0;
        let socialPlatformsMouseY = 0;
        
        function createSocialPlatformsStars() {
            const starsContainer = document.getElementById('rocket-stars-social-platforms');
            if (!starsContainer) return;
            
            const starCount = 100;
            socialPlatformsStars = [];
            
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
                socialPlatformsStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-social-platforms');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                socialPlatformsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                socialPlatformsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateSocialPlatformsStars();
            });
            
            // Initialize stars
            updateSocialPlatformsStars();
        }
        
        function updateSocialPlatformsStars() {
            socialPlatformsStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = socialPlatformsMouseX - starX;
                const dy = socialPlatformsMouseY - starY;
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
            createSocialPlatformsStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createSocialPlatformsStars);
        } else {
            createSocialPlatformsStars();
        }
    </script>
@endpush
