@php
    $status_filters = [
        'all' => [
            'key' => 'all',
            'label' => __('All'),
            'count' => 0,
        ],
        'new' => [
            'key' => 'new',
            'label' => __('Open'),
            'count' => 1,
        ],
        'closed' => [
            'key' => 'closed',
            'label' => __('Closed'),
            'count' => 2,
        ],
        //        'deleted' => [
        //            'label' => __('Deleted'),
        //        ],
    ];

    $agent_filters = [
        'all' => [
            'label' => __('All'),
        ],
        'ai' => [
            'label' => __('AI Agent'),
        ],
        'human' => [
            'label' => __('Human Agent'),
        ],
    ];

    $sort_filters = [
        'newest' => [
            'label' => __('Newest'),
        ],
        'oldest' => [
            'label' => __('Oldest'),
        ],
    ];

    $channel_filters = [
        'all' => [
            'label' => __('All Channel'),
        ],
        'frame' => [
            'label' => __('Livechat'),
        ],
    ];

    if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('chatbot-telegram')) {
        $channel_filters['telegram'] = [
            'label' => __('Telegram'),
        ];
    }

    if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('chatbot-whatsapp')) {
        $channel_filters['whatsapp'] = [
            'label' => __('Whatsapp'),
        ];
    }

    if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('chatbot-messenger')) {
        $channel_filters['messenger'] = [
            'label' => __('Messenger'),
        ];
    }
@endphp

@extends('panel.layout.app', [
    'disable_tblr' => true,
    'disable_header' => true,
    'disable_footer' => true,
    'disable_titlebar' => true,
    'layout_wide' => true,
    'disable_mobile_bottom_menu' => true,
])
@section('title', __('MagicBots'))
@section('titlebar_actions', '')

@push('css')
    <link
        rel="stylesheet"
        href="{{ custom_theme_url('/assets/libs/picmo/picmo.min.css') }}"
    />
    <style>
        .lqd-chatbot-emoji .picmo__picker.picmo__picker {
            --background-color: hsl(var(--background));
            --secondary-background-color: hsl(var(--background));
            --border-color: hsl(0 0% 0% / 5%);
            --search-background-color: hsl(0 0% 0% / 5%);
            --search-height: 40px;
            --accent-color: hsl(var(--primary));
            --ui-font-size: 14px;
            /* --picker-width: 100%; */
            /* --emoji-size-multiplier: 1; */
            /* --emoji-preview-size: 2em; */
            --emoji-size: 1.75rem;
            /* --emoji-area-height: min(300px, calc(min(var(--lqd-ext-chat-window-h), calc(100vh - (var(--lqd-ext-chat-offset-y) * 2) - var(--lqd-ext-chat-trigger-h) - var(--lqd-ext-chat-window-y-offset))) - 140px)); */
        }

        .lqd-chatbot-emoji .picmo__picker .picmo__searchContainer .picmo__searchField {
            border-radius: 8px;
            font-size: 14px;
        }

        .lqd-chatbot-emoji .picmo__picker .picmo__emojiButton {
            border-radius: 6px;
        }

        .lqd-chatbot-emoji .picmo__picker .picmo__preview {
            display: none;
        }

        @media(min-width: 992px) {
            .lqd-header {
                display: none !important;
            }

            .focus-mode .lqd-page-content-container {
                max-width: 100% !important;
            }
        }

        /* Chatbot Agent Page Background - Matching Dashboard Theme */
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
        #rocket-stars-chatbot-agent {
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
        .chatbot-agent-page-title {
            display: inline-block;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 50%, #00ff88 100%);
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
                        drop-shadow(0 0 20px rgba(0, 255, 136, 0.5));
            }
        }
        
        /* Improved Font Styling for Chatbot Agent Page */
        .lqd-ext-chatbot-history {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }
        
        /* Better Typography for Headings */
        .lqd-ext-chatbot-history-head,
        .lqd-ext-chatbot-history-head span {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 600;
            letter-spacing: -0.01em;
        }
        
        /* Improved Button and Filter Text */
        .lqd-ext-chatbot-history-sidebar button,
        .lqd-ext-chatbot-history-sidebar a,
        button[class*="lqd-"] {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        
        /* Better Text for Messages */
        .lqd-ext-chatbot-history-messages,
        .lqd-ext-chatbot-history-messages * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
        }
        
        /* Responsive Heading - handled by Tailwind classes */
        .chatbot-agent-page-title.text-xl {
            font-size: 1.25rem;
        }
        
        @media (max-width: 480px) {
            .chatbot-agent-page-title.text-xl {
                font-size: 1.125rem;
            }
        }

        /* Animated stars */
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

        /* Unique Dropdown/Popup Background Styling - Global for all dropdowns */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content,
        .lqd-dropdown-dropdown-content {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(0, 212, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 0 40px rgba(0, 212, 255, 0.2),
                0 0 80px rgba(123, 47, 247, 0.15) !important;
        }

        /* Override any default background classes */
        body[data-theme="marketing-bot-dashboard"] .bg-dropdown-background,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content.bg-dropdown-background,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[class*="bg-"],
        .lqd-ext-chatbot-history .bg-dropdown-background,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content.bg-dropdown-background {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
        }

        /* Force override for any gray/light backgrounds */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[style*="background"],
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[style*="background-color"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
        }

        /* Dropdown items hover effect - Global */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content a:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content li:hover,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content a:hover,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content button:hover,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content li:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(123, 47, 247, 0.2) 100%) !important;
            border-left: 2px solid rgba(0, 212, 255, 0.7) !important;
            transition: all 0.3s ease;
        }

        /* Active dropdown item - Global */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content a.active,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content [class*="active"],
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content a.active,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content [class*="active"] {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.25) 0%, rgba(123, 47, 247, 0.25) 100%) !important;
            border-left: 3px solid rgba(0, 212, 255, 0.9) !important;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.4) !important;
        }

        /* Dropdown text color - Global */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content *,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content span,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content p,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content *,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content span,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content p {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Dropdown checkmark icon color */
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content .text-primary,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content [class*="text-primary"] {
            color: rgba(0, 212, 255, 0.9) !important;
        }

        /* Dropdown list items spacing */
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content ul {
            background: transparent !important;
        }

        /* Dropdown border styling */
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown-content p[class*="border-b"] {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }

        /* Search form background */
        .lqd-ext-chatbot-history form[class*="absolute"],
        .lqd-ext-chatbot-history-head form[class*="absolute"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 100%) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Search input styling */
        .lqd-ext-chatbot-history form input[type="search"],
        .lqd-ext-chatbot-history-head form input[type="search"] {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .lqd-ext-chatbot-history form input[type="search"]::placeholder,
        .lqd-ext-chatbot-history-head form input[type="search"]::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* Modal/Popup styling if any */
        .lqd-ext-chatbot-history [class*="modal"],
        .lqd-ext-chatbot-history [class*="popup"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 100%) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(0, 212, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                0 0 40px rgba(0, 212, 255, 0.15),
                0 0 80px rgba(123, 47, 247, 0.1) !important;
        }

        /* Dropdown wrapper - ensure no gray background */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown,
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown {
            background: transparent !important;
        }

        /* Dropdown animation enhancement */
        .lqd-ext-chatbot-history .lqd-dropdown-dropdown {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .lqd-ext-chatbot-history .lqd-dropdown-dropdown[class*="lqd-is-active"] {
            transform: translateY(0) !important;
            opacity: 1 !important;
        }

        /* Additional override for any nested elements with gray backgrounds */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content > * {
            background: transparent !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content ul,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content li {
            background: transparent !important;
        }
    </style>
@endpush

@push('after-body-open')
    <script>
        (() => {
            document.body.classList.add('navbar-shrinked');
        })();
    </script>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-chatbot-agent"></div>
    
    <div
        class="lqd-ext-chatbot-history flex h-screen flex-col max-lg:[--header-height:65px] lg:flex-row relative z-10"
        x-data="chatbotAgentMessages"
    >
        <div
            class="lqd-ext-chatbot-history-sidebar group/history-sidebar relative flex shrink-0 flex-col bg-foreground/[3%] lg:w-[clamp(250px,27%,400px)]"
            :class="{ 'mobile-dropdown-open': mobileDropdownOpen }"
        >
            {{-- Unique Page Heading --}}
            <div class="flex items-center justify-center py-4 lg:py-6 px-4 border-b border-foreground/10">
                <span class="chatbot-agent-page-title text-xl lg:text-[2.5rem]">
                    {{ __('MagicBots') }}
                </span>
            </div>
            
            @includeIf('chatbot-agent::particles.conversations-filter')

            <div
                class="transition-all max-lg:fixed max-lg:bottom-0 max-lg:top-[calc(var(--header-height)+3.5rem)] max-lg:z-10 max-lg:flex max-lg:h-0 max-lg:w-full max-lg:flex-col max-lg:overflow-hidden max-lg:bg-background/90 max-lg:backdrop-blur-lg lg:contents max-lg:[&.active]:h-full"
                :class="{ 'active': mobile.filtersVisible }"
            >
                @includeIf('chatbot-agent::particles.conversations-sort')

                @includeIf('chatbot-agent::particles.conversations-channel-filter')

                @include('chatbot-agent::particles.conversations-list')
            </div>
        </div>

        <div
            class="lqd-ext-chatbot-history-content-wrap flex h-full grow flex-col overflow-y-auto lg:w-1/2"
            x-ref="historyContentWrap"
        >
            @include('chatbot-agent::particles.messages-header')

            <div
                class="lqd-ext-chatbot-history-messages relative flex h-full flex-col gap-2 pt-10"
                x-ref="historyMessages"
            >
                <div class="mt-auto space-y-2 px-4 xl:px-10">
                    @include('chatbot-agent::particles.messages-list')
                </div>

                @include('chatbot-agent::particles.messages-form')
            </div>
        </div>

        <div
            class="lqd-ext-chatbot-contact-info flex flex-col border-s transition-all max-lg:fixed max-lg:bottom-0 max-lg:top-[calc(var(--header-height)+3.5rem)] max-lg:z-10 max-lg:h-0 max-lg:max-h-[calc(100%-var(--header-height)-3.5rem)] max-lg:w-full max-lg:overflow-hidden max-lg:bg-background/90 max-lg:backdrop-blur-lg lg:w-[clamp(250px,27%,400px)] max-lg:[&.active]:h-full"
            :class="{ 'active': mobile.contactInfoVisible }"
        >
            @include('chatbot-agent::particles.contact-info-head')

            <div class="grid grow grid-cols-1 place-items-start overflow-y-auto">
                @include('chatbot-agent::particles.contact-info-tab-details')
                @include('chatbot-agent::particles.contact-info-tab-history')
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ custom_theme_url('/assets/libs/fslightbox/fslightbox.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/picmo/picmo.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/markdown-it.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    @if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('chatbot-agent'))
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @endif

    <script
        src="https://cdn.ably.com/lib/ably.min-1.js"
        type="text/javascript"
    ></script>
    <script>
        // Interactive Stars for Chatbot Agent Page
        let chatbotAgentStars = [];
        let chatbotAgentMouseX = 50;
        let chatbotAgentMouseY = 50;
        
        function createChatbotAgentStars() {
            const starsContainer = document.getElementById('rocket-stars-chatbot-agent');
            if (!starsContainer) return;
            
            const starCount = 100;
            chatbotAgentStars = [];
            
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
                chatbotAgentStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-chatbot-agent');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                chatbotAgentMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                chatbotAgentMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateChatbotAgentStars();
            });
            
            // Initialize stars
            updateChatbotAgentStars();
        }
        
        function updateChatbotAgentStars() {
            chatbotAgentStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = chatbotAgentMouseX - starX;
                const dy = chatbotAgentMouseY - starY;
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
            createChatbotAgentStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createChatbotAgentStars);
        } else {
            createChatbotAgentStars();
        }
    </script>
    <script>
        (() => {
            document.addEventListener('alpine:init', () => {
                Alpine.data('chatbotAgentMessages', () => ({
                    selectedStatus: {
                        label: '{{ __('All') }}',
                        count: 0,
                        status: 'all'
                    },
                    statusCount: {
                        all: 0,
                        new: 0,
                        closed: 0,
                    },
                    filters: {
                        status: '{{ array_key_first($status_filters) }}',
                        agent: '{{ array_key_first($agent_filters) }}',
                        sort: '{{ array_key_first($sort_filters) }}',
                        channel: '{{ array_key_first($channel_filters) }}',
                        unreadsOnly: false,
                    },
                    chatsList: [],
                    attachmentsPreview: [],
                    activeChat: null,
                    activeSessionId: null,
                    fetching: false,
                    allLoaded: false,
                    /** * @type {IntersectionObserver} */
                    loadMoreIO: null,
                    originalLoadMoreHref: null,
                    mobileDropdownOpen: false,
                    messageTime: null,
                    conversationsSearchFormVisible: false,
                    messagesSearchFormVisible: false,
                    showEmojiPicker: false,
                    contactInfo: {
                        activeTab: 'details',
                        editMode: false,
                    },
                    mobile: {
                        filtersVisible: false,
                        contactInfoVisible: false,
                    },
                    userConversationHistory: [],

                    async init() {
                        this.onSendMessage = this.onSendMessage.bind(this);
                        this.setActiveChat = this.setActiveChat.bind(this);

                        this.originalLoadMoreHref = this.$refs.loadMore.href;

                        await this.fetchChats({
                            loadMore: true
                        });

                        await this.initAbly();

                        await this.getConversationsHistory(this.activeChat?.session_id);

                        this.setupLoadMoreIO();

                        Alpine.store('chatbotAgentMessages', this);

                        this.initEmojiPicker();
                    },
                    initEmojiPicker() {
                        const picker = picmo.createPicker({
                            rootElement: this.$refs.emojiPicker
                        });

                        picker.addEventListener('emoji:select', event => {
                            this.$refs.message.value += event.emoji;
                            this.showEmojiPicker = false;

                            this.$refs.message.focus()
                        });
                    },
                    async loadMore() {
                        if (this.fetching || this.allLoaded) return;

                        await this.fetchChats({
                            loadMore: true
                        });
                    },
                    setupLoadMoreIO() {
                        this.loadMoreIO = new IntersectionObserver(async ([entry], observer) => {
                            if (entry.isIntersecting && !this.fetching && !this.allLoaded) {
                                await this.loadMore();
                            }
                        });

                        this.loadMoreIO.observe(this.$refs.loadMoreWrap);
                    },
                    async updateConversationDetails({
                        name = '',
                        color = ''
                    }) {
                        @if ($app_is_demo)
                            toastr.error('This feature is disabled in demo version.');
                            return;
                        @else
                            name = name || this.$refs.conversationNameInput.value;
                            color = color || this.activeChat.color;

                            let conversation_name = name.trim();
                            let conversation_color = color.trim();

                            const res = await fetch('{{ route('dashboard.chatbot-agent.conversations.update') }}', {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    conversation_id: this.activeChat.id,
                                    conversation_name: conversation_name,
                                    color: conversation_color,
                                }),
                            });
                            const data = await res.json();

                            if (!res.ok) {
                                toastr.error(data.message || '{{ __('Failed to update conversation details.') }}');
                                return;
                            }

                            this.activeChat.conversation_name = conversation_name;
                            this.activeChat.color = conversation_color;

                            toastr.success('{{ __('Conversation details updated successfully.') }}');
                        @endif
                    },
                    async initAbly() {
						@if(setting('ably_public_key') && is_string(setting('ably_public_key')) && strlen(setting('ably_public_key')) > 8)
						const realtime = new Ably.Realtime.Promise("{{ setting('ably_public_key') }}");

						const channel = realtime.channels.get("panel-conversation-{{ \Illuminate\Support\Facades\Auth::id() }}");

						await channel.subscribe("conversation", async message => {
							const newMessageData = message.data.chatbotConversation;
							const newMessageId = newMessageData.id;
							const conversationIsActive = newMessageId === this.activeChat.id;
							const conversationIndex = this.chatsList.findIndex(chat => chat.id === newMessageId);

							// if it's a new conversation
							if (conversationIndex === -1) {
								newMessageData.histories = [...newMessageData.histories || [], newMessageData.lastMessage];
								this.chatsList.unshift(newMessageData);
							} else {
								const conversation = this.chatsList.at(conversationIndex);
								conversation.histories?.push(newMessageData.lastMessage);
								conversation.lastMessage = newMessageData.lastMessage;
							}
						});
						@endif
                    },

                    async onSendMessage() {
                        @if ($app_is_demo)
                            toastr.error('This feature is disabled in demo version.');
                            return;
                        @else
                            const messageInput = this.$refs.message;
                            const mediaInput = this.$refs.media;
                            const messageString = messageInput.value.trim();

                            if (!messageString && !mediaInput.files.length) {
                                return toastr.error('{{ __('Please fill required fields.') }}')
                            };

                            const newUserMessage = {
                                id: new Date().getTime(),
                                message: messageString,
                                media_name: mediaInput.files.length ? mediaInput.files[0].name : '',
                                media_url: mediaInput.files.length ? '#' : '',
                                role: 'assistant',
                                user: true,
                                created_at: new Date().toLocaleString()
                            };
                            const formData = new FormData();

                            let chatIndex = this.chatsList.findIndex(chat => chat.id == this.activeChat.id);

                            if (chatIndex !== -1) {
                                const histories = this.chatsList[chatIndex].histories;

                                if (!Array.isArray(histories)) {
                                    this.chatsList[chatIndex].histories = [];
                                } else {
                                    this.chatsList[chatIndex].histories = histories;
                                }

                                this.chatsList[chatIndex].histories.push(newUserMessage);
                            }

                            this.scrollMessagesToBottom();

                            const promises = [];
                            const files = mediaInput.files;
                            const messagesArray = [
                                ['message', messageString]
                            ];

                            const sendFirstMessage = async () => {
                                const formData = new FormData();

                                formData.append('conversation_id', this.activeChat.id);
                                formData.append('message', messageString);

                                if (files.length) {
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(files[0]);

                                    formData.append('media', dataTransfer.files[0]);
                                }

                                const res = await fetch('{{ route('dashboard.chatbot-agent.history') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                    },
                                    body: formData
                                });

                                return await res.json();
                            }
                            const sendTheRestAttachments = async () => {
                                if (files.length <= 1) {
                                    return [Promise.resolve(true)];
                                };

                                return Array.from(files).map(async (file, index) => {
                                    if (index === 0) return;

                                    const formData = new FormData();
                                    const dataTransfer = new DataTransfer();

                                    dataTransfer.items.add(file);

                                    formData.append('conversation_id', this.activeChat.id);
                                    formData.append('media', dataTransfer.files[0]);

                                    const res = await fetch('{{ route('dashboard.chatbot-agent.history') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                        },
                                        body: formData
                                    });

                                    return await res.json();
                                });

                            }

                            messageInput.value = '';
                            this.attachmentsPreview = [];
                            this.$refs.submitBtn.setAttribute('disabled', 'disabled');

                            Promise.all([sendFirstMessage(), sendTheRestAttachments()])
                                .then(([firstMessage]) => {
                                    mediaInput.value = null;

                                    this.chatsList[chatIndex].histories.at(-1).media_name = firstMessage.data.media_name;
                                    this.chatsList[chatIndex].histories.at(-1).media_url = firstMessage.data.media_url;
                                })
                                .catch(e => {
                                    toastr.error('{{ __('Something went wrong. Please try again later.') }}')
                                });
                        @endif
                    },
                    onMessageFieldHitEnter(event) {
                        if (!event.shiftKey) {
                            this.onSendMessage();
                        } else {
                            event.target.value += '\n';
                            event.target.scrollTop = event.target.scrollHeight
                        };
                    },
                    onMessageFieldInput(event) {
                        const messageString = this.$refs.message.value.trim();

                        if (messageString) {
                            this.$refs.submitBtn.removeAttribute('disabled');
                        } else {
                            this.$refs.submitBtn.setAttribute('disabled', 'disabled');
                        }
                    },
                    async fetchHistories(id) {
                        const res = await fetch('{{ route('dashboard.chatbot-agent.history') }}?conversation_id=' + id, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                        });

                        const data = await res.json();

                        return data.data;
                    },
                    async fetchChats(opts = {}) {
                        const options = {
                            loadMore: false,
                            ...opts
                        };

                        if (!options.loadMore) {
                            this.$refs.loadMore.href = this.originalLoadMoreHref;
                        }

                        this.fetching = true;

                        const res = await fetch(
                            `${this.$refs.loadMore.href}&agentFilter=${this.filters.agent}&chatbot_channel=${this.filters.channel}&status=${this.filters.status}&unread=${this.filters.unreadsOnly}&sort=${this.filters.sort}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                            });
                        const data = await res.json();

                        let {
                            data: conversations,
                            status_count: statusCount,
                        } = data;



                        if (!res.ok || !conversations) {
                            if (data.message) {
                                toastr.error(data.message);
                            }
                            return;
                        }

                        this.statusCount = statusCount;

                        if (this.selectedStatus.status === '{{ $status_filters['all']['key'] }}') {
                            this.selectedStatus = {
                                label: '{{ $status_filters['all']['label'] }}',
                                count: statusCount.all ?? 0,
                                status: 'all'
                            }
                        } else if (this.selectedStatus.status === '{{ $status_filters['new']['key'] }}') {
                            this.selectedStatus = {
                                label: '{{ $status_filters['new']['label'] }}',
                                count: statusCount.new ?? 0,
                                status: 'new'
                            }
                        } else if (this.selectedStatus.status === '{{ $status_filters['closed']['key'] }}') {
                            this.selectedStatus = {
                                label: '{{ $status_filters['closed']['label'] }}',
                                count: statusCount.closed ?? 0,
                                status: 'closed'
                            }
                        }

                        this.lastTimeFetch = new Date().getTime();

                        if (!options.loadMore) {
                            this.chatsList = conversations;
                        } else {
                            this.chatsList.push(...conversations);
                        }

                        this.allLoaded = data.meta.current_page >= data.meta.last_page;

                        this.$refs.loadMore.href = data.links.next ?? data.links.first;

                        if ((!options.loadMore || !this.activeChat) && this.chatsList.length) {
                            this.activeChat = this.chatsList[0];
                        }

                        this.fetching = false;

                        this.scrollMessagesToBottom();
                    },
                    async handleConversationsSearch() {
                        const query = this.$refs.historySearchInput?.value?.trim();
                        this.fetching = true;

                        const res = await fetch('{{ route('dashboard.chatbot-agent.conversations.search') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                search: query,
                            }),
                        });
                        const data = await res.json();
                        const {
                            data: conversations
                        } = data;

                        if (!res.ok || !conversations) {
                            if (data.message) {
                                toastr.error(data.message);
                            }
                            return;
                        }

                        this.chatsList = conversations;
                        this.allLoaded = true;

                        if (conversations.length) {
                            this.activeChat = conversations;
                        } else {
                            this.activeChat = null;
                        }

                        this.fetching = false;
                        this.scrollMessagesToBottom();
                    },
                    async handleMessagesSearch(inputElement) {
                        const searchString = inputElement.value;

                        if (!searchString.trim()) {
                            if (this.activeChat) {
                                this.activeChat.histories = await this.fetchHistories(this.activeChat.id);
                            }
                            return;
                        }

                        if (this.activeChat?.histories) {
                            const filteredHistories = this.activeChat.histories.filter(message =>
                                message.message && message.message.toLowerCase().includes(searchString.toLowerCase())
                            );

                            this.activeChat.histories = filteredHistories;
                        }
                    },

                    async filterAgent(agent) {
                        if (this.filters.agent === agent) return;

                        this.filters.agent = agent;

                        await this.fetchChats();
                    },

                    async filterStatus(status, label) {
                        if (this.filters.status === status) return;

                        this.filters.status = status;

                        this.selectedStatus = {
                            label: label,
                            status: status,
                            count: this.statusCount[status] ?? 0
                        }

                        this.fetchChats();

                        toastr.success('{{ trans('Filter ticket status') }}')
                    },

                    async filterSort(sort) {
                        if (this.filters.sort === sort) return;

                        this.filters.sort = sort;

                        await this.fetchChats();
                    },

                    async filterUnread(event) {
                        const checkbox = event.target;
                        const unreadsOnly = checkbox.checked;

                        if (this.filters.unreadsOnly === unreadsOnly) return;

                        this.filters.unreadsOnly = unreadsOnly;

                        await this.fetchChats();
                    },
                    async exportHistory(conversationId) {
                        if (conversationId == null) return;

                        @if ($app_is_demo)
                            return toastr.error('This feature is disabled in demo version.');
                        @else
                            const {
                                jsPDF
                            } = window.jspdf;
                            const doc = new jsPDF();

                            fetch('{{ route('dashboard.chatbot-agent.history') }}?conversation_id=' + conversationId)
                                .then(response => response.json())
                                .then(messages => {
                                    let y = 20;
                                    messages.data.forEach(msg => {
                                        let prefix = msg.role === 'user' ? 'User: ' : 'Agent: ';
                                        doc.text(prefix + msg.message, 10, y);
                                        y += 10;
                                    });
                                    doc.save('messages.pdf');
                                });
                        @endif
                    },

                    async closeConversation(conversationId) {
                        if (conversationId == null) return;

                        @if ($app_is_demo)
                            return toastr.error('This feature is disabled in demo version.');
                        @endif

                        if (!confirm('Do you want closed this conversation history?')) {
                            return;
                        }

                        const res = await fetch('{{ route('dashboard.chatbot-agent.conversations.closed') }}?conversation_id=' + conversationId, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                        });

                        const data = await res.json();

                        if (data.status === 'success') {
                            const chatIndex = this.chatsList.findIndex(chat => chat.id == this.activeChat.id);

                            if (chatIndex === -1) return;

                            this.chatsList.splice(chatIndex, 1);

                            this.activeChat = this.chatsList.at(Math.max(0, Math.min(this.chatsList.length - 1, chatIndex)));

                            toastr.success('{{ __('Conversation closed successfully.') }}');
                        } else {
                            toastr.error(data.message || '{{ __('Failed to close conversation.') }}');
                        }
                    },

                    async pinConversation(conversationId) {
                        if (conversationId == null) return;

                        @if ($app_is_demo)
                            return toastr.error('This feature is disabled in demo version.');
                        @endif

                        const res = await fetch('{{ route('dashboard.chatbot-agent.conversations.pinned') }}?conversation_id=' + conversationId, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                        });

                        const data = await res.json();

                        if (data.status === 'success') {
                            const chat = this.chatsList.find(chat => chat.id == data.data.id);

                            if (!chat) return;

                            chat.pinned = data.data.pinned;

                            // Re-sort chatsList to reflect the pinned status
                            this.chatsList.sort((a, b) => {
                                // First sort by pinned status (higher pinned numbers first)
                                if (a.pinned !== b.pinned) {
                                    return b.pinned - a.pinned;
                                }

                                // If both have same pinned status, sort by date based on filters.sort
                                const aDate = new Date(a.updated_at || a.created_at);
                                const bDate = new Date(b.updated_at || b.created_at);

                                if (this.filters.sort === 'newest') {
                                    return bDate - aDate;
                                } else {
                                    return aDate - bDate;
                                }
                            });

                            toastr.success(data.message ?? '{{ __('Conversation pin status updated successfully.') }}');
                        } else {
                            toastr.error(data.message || '{{ __('Failed to update conversation pin status.') }}');
                        }
                    },

                    async getConversationsHistory(sessionId) {
                        if (sessionId == null) return;

                        this.activeSessionId = sessionId;

                        const res = await fetch(
                            `{{ route('dashboard.chatbot-agent.conversations.history.session') }}?sessionId=${sessionId}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                            });
                        const data = await res.json();
                        const {
                            data: conversations
                        } = data;

                        if (!res.ok || !conversations) {
                            if (data.message) {
                                toastr.error(data.message);
                            }
                            return;
                        }

                        this.userConversationHistory = conversations;
                    },

                    async deleteConversation(conversationId) {
                        if (conversationId == null) return;

                        @if ($app_is_demo)
                            toastr.error('This feature is disabled in demo version.');
                            return;
                        @else
                            if (!confirm('Do you want delete this conversation history?')) {
                                return;
                            }

                            const res = await fetch('{{ route('dashboard.chatbot-agent.destroy') }}', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    conversation_id: conversationId,
                                }),
                            });
                            const responseData = await res.json();

                            if (responseData.status == 'success') {
                                const chatIndex = this.chatsList.findIndex(chat => chat.id == this.activeChat.id);

                                if (chatIndex === -1) return;

                                this.chatsList.splice(chatIndex, 1);

                                this.activeChat = this.chatsList.at(Math.max(0, Math.min(this.chatsList.length - 1, chatIndex)));
                            }
                        @endif
                    },

                    async setActiveChat(chatId) {
                        if (chatId == null) return;

                        this.activeChat = this.chatsList.find(chat => chat.id == chatId);
                        this.activeChat.histories = await this.fetchHistories(this.activeChat.id);

                        this.mobileDropdownOpen = false;

                        this.mobile.filtersVisible = false;

                        await this.getConversationsHistory(this.activeChat?.sessionId);

                        this.scrollMessagesToBottom();
                    },

                    setAttachmentsPreview() {
                        this.attachmentsPreview = [];

                        for (const file of this.$refs.media.files) {
                            const reader = new FileReader();

                            reader.onload = e => {
                                this.attachmentsPreview.push({
                                    url: e.target.result,
                                    type: file.type
                                });
                            };

                            reader.readAsDataURL(file);
                        }
                    },

                    getFormattedString(string) {
                        if (!('markdownit' in window) || !string) return string;

                        string
                            .replace(/>(\s*\r?\n\s*)</g, '><')
                            .replace(/\n(?!.*\n)/, '');

                        const renderer = window.markdownit({
                            breaks: true,
                            highlight: (str, lang) => {
                                const language = lang && lang !== '' ? lang : 'md';
                                const codeString = str;

                                if (Prism.languages[language]) {
                                    const highlighted = Prism.highlight(codeString,
                                        Prism.languages[language], language);
                                    return `<pre class="language-${language}"><code data-lang="${language}" class="language-${language}">${highlighted}</code></pre>`;
                                }

                                return codeString;
                            }
                        });

                        renderer.use(function(md) {
                            md.core.ruler.after('inline', 'convert_links', function(state) {
                                state.tokens.forEach(function(blockToken) {

                                    if (blockToken.type !== 'inline') return;

                                    blockToken.children.forEach(function(token, idx) {
                                        const {
                                            content
                                        } = token;
                                        if (content.includes('<a ')) {
                                            const linkRegex = /(.*)(<a\s+[^>]*\s+href="([^"]+)"[^>]*>([^<]*)<\/a>?)(.*)/;
                                            const linkMatch = content.match(linkRegex);

                                            if (linkMatch) {
                                                const [, before, , href, text, after] = linkMatch;

                                                const beforeToken = new state.Token('text', '', 0);
                                                beforeToken.content = before;

                                                const newToken = new state.Token('link_open', 'a', 1);
                                                newToken.attrs = [
                                                    ['href', href],
                                                    ['target', '_blank']
                                                ];
                                                const textToken = new state.Token('text', '', 0);
                                                textToken.content = text;
                                                const closingToken = new state.Token('link_close', 'a', -1);

                                                const afterToken = new state.Token('text', '', 0);
                                                afterToken.content = after;

                                                blockToken.children
                                                    .splice(idx, 1, beforeToken, newToken, textToken, closingToken, afterToken);
                                            }
                                        }
                                    });
                                });
                            });
                        });

                        return renderer.render(renderer.utils.unescapeAll(string));
                    },
                    getUnreadMessages(chatId) {
                        if (chatId == null) return;

                        let chat = this.chatsList.find(chat => chat.id === chatId);

                        if (!chat) return;

                        return chat?.histories?.filter(history => history.role == 'user' && history.read_at == null)?.length ?? 0;
                    },

                    getAllUnreadMessages() {
                        const unreadMessages = this.chatsList?.reduce((previousValue, chat) => {
                            return previousValue + (this.getUnreadMessages(chat.id) ?? 0);
                        }, 0);

                        return unreadMessages;
                    },

                    scrollMessagesToBottom(smooth = false) {
                        this.$nextTick(() => {
                            this.$refs.historyContentWrap.scrollTo({
                                top: this.$refs.historyContentWrap.scrollHeight,
                                behavior: smooth ? 'smooth' : 'auto'
                            });
                        })
                    },
                    getDiffHumanTime(time) {
                        const diff = Math.floor((new Date() - new Date(time)) / 1000);

                        return diff < 60 ? " {{ __('Just now') }}" :
                            diff < 3600 ? (Math.floor(diff / 60) === 1 ?
                                "1 {{ __('minute ago') }}" : Math.floor(diff / 60) +
                                " {{ __('minutes ago') }}") :
                            diff < 86400 ? (Math.floor(diff / 3600) === 1 ?
                                "1 {{ __('hour ago') }}" : Math.floor(diff / 3600) +
                                " {{ __('hours ago') }}") :
                            Math.floor(diff / 86400) === 1 ? "1 {{ __('day ago') }}" : Math.floor(
                                diff / 86400) + " {{ __('days ago') }}"
                    },

                    getShortDiffHumanTime(time) {
                        const diff = Math.floor((new Date() - new Date(time)) / 1000);

                        return diff < 60 ? '{{ __('Just now') }}' :
                            diff < 3600 ? Math.floor(diff / 60) + '{{ __('m') }}' :
                            diff < 86400 ? Math.floor(diff / 3600) + '{{ __('h') }}' :
                            Math.floor(diff / 86400) + '{{ __('d') }}'
                    }
                }));
            });
        })();
    </script>
@endpush
