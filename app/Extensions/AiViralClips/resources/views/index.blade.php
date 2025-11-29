@extends('panel.layout.app', [
    'disable_tblr' => true,
])

@section('title', __('AI Viral Clips'))
@section('titlebar_title')
    <span class="ai-viral-clips-page-title">
        {{ __('AI Viral Clips') }}
    </span>
@endsection
@section('titlebar_subtitle', __('Generate viral clips from long video content.'))
@section('titlebar_actions', '')

@push('css')
    <style>
        /* AI Viral Clips Page Background - Matching Dashboard Theme */
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
        #rocket-stars-ai-viral-clips {
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
        .ai-viral-clips-page-title {
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
            .ai-viral-clips-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .ai-viral-clips-page-title {
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
        
        /* Create Clips Window Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window-header {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window input,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window textarea,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window select {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window textarea:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window select:focus {
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Buttons Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window .lqd-button,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window .lqd-button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }
        
        /* Dropdowns Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="menu"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="dropdown"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="menu"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window select,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="select"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="menuitem"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="dropdown-item"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window option,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="option"] {
            background: rgba(10, 14, 39, 0.95) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="menuitem"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="dropdown-item"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window option:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="option"]:hover {
            background: rgba(0, 212, 255, 0.2) !important;
            color: rgba(0, 212, 255, 0.9) !important;
        }
        
        /* Select dropdown arrow */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2300d4ff' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            padding-right: 2.5rem !important;
        }
        
        /* Custom dropdown components */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="dropdown-menu"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="dropdown-content"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
        }
        
        /* Tabs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="tab"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="tab"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window button[class*="tab"] {
            color: rgba(255, 255, 255, 0.7) !important;
            background: rgba(10, 14, 39, 0.5) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="tab"][aria-selected="true"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="tab"][aria-selected="true"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="lqd-is-active"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window button[class*="lqd-is-active"] {
            color: rgba(0, 212, 255, 0.9) !important;
            background: rgba(0, 212, 255, 0.15) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [role="tab"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="tab"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window button[class*="tab"]:hover {
            background: rgba(0, 212, 255, 0.1) !important;
            color: rgba(0, 212, 255, 0.8) !important;
        }
        
        /* Tab container background */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window [class*="bg-foreground/5"],
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window ul[class*="bg-"] {
            background: rgba(10, 14, 39, 0.3) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window .text-heading-foreground {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-chatbot-edit-window .text-foreground {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Action Card Styling */
        .ai-viral-clips-action-card-wrapper {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .ai-viral-clips-action-card-wrapper::before {
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
        
        .ai-viral-clips-action-card-wrapper:hover::before {
            opacity: 1;
        }
        
        .ai-viral-clips-action-card-wrapper:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Icon Container Styling */
        .ai-viral-clips-icon-container {
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
            border: 2px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(123, 47, 247, 0.2);
            transition: all 0.3s ease;
        }
        
        .ai-viral-clips-action-card-wrapper:hover .ai-viral-clips-icon-container {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 0 40px rgba(0, 212, 255, 0.5), inset 0 0 30px rgba(123, 47, 247, 0.3);
        }
        
        /* Icon Wrapper Styling */
        .ai-viral-clips-icon-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .ai-viral-clips-icon {
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
        .ai-viral-clips-action-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        .ai-viral-clips-action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-ai-viral-clips"></div>
    
    <div class="py-10 relative z-10">
        <div
            class="lqd-external-chatbot-edit"
            x-data="aiInflucencerData"
        >
            @include('ai-viral-clips::create-clips.create-clips-window', ['overlay' => false])
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for AI Viral Clips Page
        let aiViralClipsStars = [];
        let aiViralClipsMouseX = 0;
        let aiViralClipsMouseY = 0;
        
        function createAiViralClipsStars() {
            const starsContainer = document.getElementById('rocket-stars-ai-viral-clips');
            if (!starsContainer) return;
            
            const starCount = 100;
            aiViralClipsStars = [];
            
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
                aiViralClipsStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-ai-viral-clips');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                aiViralClipsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                aiViralClipsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateAiViralClipsStars();
            });
            
            // Initialize stars
            updateAiViralClipsStars();
        }
        
        function updateAiViralClipsStars() {
            aiViralClipsStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = aiViralClipsMouseX - starX;
                const dy = aiViralClipsMouseY - starY;
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
            createAiViralClipsStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createAiViralClipsStars);
        } else {
            createAiViralClipsStars();
        }
    </script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiInflucencerData', () => ({
                aiClipsWindowKey: 0,
                init() {
                    Alpine.store('aiInflucencerData', this);
                    this.toggleWindow();
                },
                // when open or close the window, change some neccessary css.
                toggleWindow(open = true) {
                    Alpine.nextTick(() => {
                        this.aiClipsWindowKey = 1;
                    })
                }
            }))
        });
    </script>
@endpush
