@php
    $user_avatar = Auth::user()->avatar;

    if (!Auth::user()->github_token && !Auth::user()->google_token && !Auth::user()->facebook_token) {
        $user_avatar = '/' . $user_avatar;
    }
    $human_agent_conditions = [
        'When the issue is too complex or ambiguous.',
        'When the customer is frustrated or dissatisfied.',
        'When sensitive topics (legal, financial, medical, etc.) are involved.',
        'When the AI fails to understand after repeated attempts.',
        'When empathy or emotional intelligence is required.',
        'When the request is outside the AI’s scope or permissions.',
        'When the customer explicitly requests a human.',
    ];
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', $setting->site_name . __('Bots'))
@section('titlebar_title')
    <span class="chatbots-page-title">
        {{ $setting->site_name . __('Bots') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('View and manage external chatbots') }}
@endsection
@section('titlebar_actions')
    <x-button
        href="#"
        variant="ghost-shadow"
        @click.prevent="$store.externalChatbotHistory.setOpen(true)"
        x-data="{}"
    >
        @lang('Chat History')
    </x-button>

    <x-button
        href="#"
        @click.prevent="$store.externalChatbotEditor.setActiveChatbot('new_chatbot', 1, true);"
        x-data="{}"
    >
        <x-tabler-plus class="size-4" />
        @lang('Add New Chatbot')
    </x-button>
@endsection

@push('css')
    <style>
        /* Chatbots Page Background - Matching Documents Theme */
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
        #rocket-stars-chatbots {
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
        .chatbots-page-title {
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
            padding:7px;
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
        
        /* Improved Font Styling for Chatbots Page */
        .lqd-page-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }
        
        /* Better Typography for Headings */
        .lqd-titlebar-title {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .chatbots-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .chatbots-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Chatbot Stats Card - Gradient Background */
        .chatbot-stats-card-wrapper {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Chatbot Action Cards - Modern Gradient Backgrounds */
        .chatbot-action-card-wrapper {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .chatbot-action-card-wrapper::before {
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
        
        .chatbot-action-card-wrapper:hover::before {
            opacity: 1;
        }
        
        .chatbot-action-card-wrapper:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Icon Container Styling */
        .chatbot-icon-container {
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
            border: 2px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(123, 47, 247, 0.2);
            transition: all 0.3s ease;
        }
        
        .chatbot-action-card-wrapper:hover .chatbot-icon-container {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 0 40px rgba(0, 212, 255, 0.5), inset 0 0 30px rgba(123, 47, 247, 0.3);
        }
        
        /* SVG Icon Styling */
        .chatbot-icon-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .chatbot-icon {
            width: 80px;
            height: 80px;
            filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6));
            animation: iconFloat 3s ease-in-out infinite;
        }
        
        .create-icon .chatbot-icon {
            animation-delay: 0s;
        }
        
        .explore-icon .chatbot-icon {
            animation-delay: 0.5s;
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
        
        /* Typing Animation for Explore Icon */
        @keyframes typingPulse {
            0%, 100% { 
                opacity: 0.3;
                transform: scale(0.8);
            }
            50% { 
                opacity: 1;
                transform: scale(1.2);
            }
        }
        
        .typing-dot {
            animation: typingPulse 1.5s ease-in-out infinite;
        }
        
        /* Action Buttons Styling */
        .chatbot-action-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        .chatbot-action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }
        
        /* Stats Links Styling */
        .chatbot-stats-card a {
            transition: all 0.3s ease;
        }
        
        .chatbot-stats-card a:hover {
            transform: translateX(5px);
        }
        
        .chatbot-stats-card a span:first-child {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .chatbot-stats-card a:hover span:first-child {
            color: rgba(0, 212, 255, 1);
        }
        
        .chatbot-stats-card a span:last-child {
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* Active Chatbots Card Styling - Remove Gray Background */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card,
        body[data-theme="marketing-bot-dashboard"] .py-14 [class*="card"],
        body[data-theme="marketing-bot-dashboard"] .py-14 x-card,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card-variant-outline,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card-variant-shadow,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card-variant-outline-shadow {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Override any default card background colors */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card.bg-card-background,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card[class*="bg-"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
        }

        /* Card Hover Effect */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card:hover,
        body[data-theme="marketing-bot-dashboard"] .py-14 [class*="card"]:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }

        /* Card Content Styling */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card h3,
        body[data-theme="marketing-bot-dashboard"] .py-14 [class*="card"] h3 {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card p,
        body[data-theme="marketing-bot-dashboard"] .py-14 [class*="card"] p {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Active Status Badge */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card .lqd-active {
            background: rgba(34, 197, 94, 0.15) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
            color: rgba(34, 197, 94, 0.9) !important;
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.3);
        }

        /* Passive Status Badge */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card .lqd-passive {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Card Head Section */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card [class*="head"],
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card header,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card .lqd-card-head {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1) !important;
            background: transparent !important;
            background-color: transparent !important;
        }

        /* Card Body Section */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card [class*="body"],
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card .lqd-card-body {
            background: transparent !important;
            background-color: transparent !important;
        }

        /* Icons in Card */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card svg,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card [class*="icon"] {
            color: rgba(0, 212, 255, 0.7) !important;
            filter: drop-shadow(0 0 5px rgba(0, 212, 255, 0.3));
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card:hover svg,
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card:hover [class*="icon"] {
            color: rgba(0, 212, 255, 0.9) !important;
            filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.5));
        }

        /* Avatar Border Glow */
        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card img[class*="rounded-full"] {
            border: 2px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .py-14 .lqd-card:hover img[class*="rounded-full"] {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-chatbots"></div>
    
    <div class="py-10 relative z-10">
        <div
            class="lqd-external-chatbot-edit"
            x-data="externalChatbotEditor"
            @keydown.escape.window="setActiveChatbot(null)"
        >
            @include('chatbot::home.actions-grid')

            @include('chatbot::home.chatbots-list', ['chatbots' => $chatbots])

            @include('chatbot::home.edit-window.edit-window', ['avatars' => $avatars])
        </div>

        @include('chatbot::home.chats-history.chats-history')
    </div>
@endsection

@push('script')
    <link
        rel="stylesheet"
        href="{{ custom_theme_url('/assets/libs/prism/prism.css') }}"
    />
    <link
        rel="stylesheet"
        href="{{ custom_theme_url('assets/libs/jscolorpicker/dist/colorpicker.css') }}"
    >
    <script src="{{ custom_theme_url('assets/libs/jscolorpicker/dist/colorpicker.iife.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/prism/prism.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/beautify-html.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/markdown-it.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/turndown.js') }}"></script>

    <script>
        // Interactive Stars Background for Chatbots Page
        let chatbotsStars = [];
        let chatbotsMouseX = 0;
        let chatbotsMouseY = 0;
        
        function createChatbotsStars() {
            const starsContainer = document.getElementById('rocket-stars-chatbots');
            if (!starsContainer) return;
            
            const starCount = 100;
            chatbotsStars = [];
            
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
                chatbotsStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-chatbots');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                chatbotsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                chatbotsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateChatbotsStars();
            });
            
            // Initialize stars
            updateChatbotsStars();
        }
        
        function updateChatbotsStars() {
            chatbotsStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = chatbotsMouseX - starX;
                const dy = chatbotsMouseY - starY;
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
            createChatbotsStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createChatbotsStars);
        } else {
            createChatbotsStars();
        }
    </script>

    <script>
        (() => {
            document.addEventListener('alpine:init', () => {
                Alpine.data('externalChatbotEditor', () => ({
                    chatbots: @json($chatbots),
                    activeChatbot: {},
                    prevActiveChatbotId: null,
                    editingStep: 1,
                    submittingData: false,
                    // used for the chatbot ui
                    externalChatbot: null,
                    // used for the training tab
                    externalChatbotTraining: null,
                    testIframeWidth: 420,
                    testIframeHeight: 745,
                    defaultFormInputs: {
                        id: '',
                        interaction_type: 'automatic_response',
                        title: '{{ $setting->site_name . __('Bots') }}',
                        bubble_message: '{{ __('Hey there, How can I help you?') }}',
                        welcome_message: '{{ __('Hi, how can I help you?') }}',
                        connect_message: '{{ __('I’ve forwarded your request to a human agent. An agent will connect with you as soon as possible.') }}',
                        instructions: '',
                        do_not_go_beyond_instructions: 0,
                        language: '',
                        ai_model: 'gpt-3.5-turbo',
                        logo: '',
                        avatar: (@json($avatars?->isEmpty() ? [] : $avatars->random()))?.avatar || '{{ $user_avatar }}',
                        color: '#272733',
                        show_logo: true,
                        show_date_and_time: true,
                        show_average_response_time: true,
                        trigger_background: '',
                        trigger_avatar_size: '60px',
                        position: 'right',
                        active: true,
                        footer_link: '',
                        whatsapp_link: '',
                        telegram_link: '',
                        watch_product_tour_link: '',
                        is_email_collect: true,
                        is_contact: true,
                        is_attachment: true,
                        is_emoji: true,
                        is_articles: true,
                        is_links: true,
                        header_bg_type: 'color',
                        header_bg_color: '',
                        header_bg_gradient: '',
                        header_bg_image: '',
                        header_bg_image_blob: null,
                        human_agent_conditions: []
                    },
                    formErrors: {},
                    contactInfo: {
                        activeTab: 'details',
                        editMode: false,
                    },
                    mobile: {
                        filtersVisible: false,
                        contactInfoVisible: false,
                    },

                    init() {
                        this.createNewChatObj();
                        this.initFormErrors();

                        Alpine.store('externalChatbotEditor', this);
                    },
                    createNewChatObj() {
                        this.chatbots.data.unshift({
                            ...this.defaultFormInputs,
                            id: 'new_chatbot',
                        })
                    },
                    initFormErrors() {
                        Object.keys(this.defaultFormInputs).forEach(key => {
                            this.formErrors[key] = [];
                        });
                    },
                    setActiveChatbot(chatbotId, step, skipCRUD = false) {
                        const topNoticeBar = document.querySelector('.top-notice-bar');
                        const navbar = document.querySelector('.lqd-navbar');
                        const pageContentWrap = document.querySelector('.lqd-page-content-wrap');
                        const navbarExpander = document.querySelector('.lqd-navbar-expander');

                        const activeChatbotId = this.activeChatbot.id;

                        this.activeChatbot = this.chatbots.data.find(c => c.id === chatbotId) || {
                            id: chatbotId
                        };

                        if (activeChatbotId) {
                            this.prevActiveChatbotId = activeChatbotId;
                        }

                        if (step) {
                            this.setEditingStep(step, skipCRUD);
                        }

                        this.formErrors = {};

                        document.documentElement.style.overflow = this.activeChatbot.id ? 'hidden' : '';

                        if (window.innerWidth >= 992) {

                            if (navbar) {
                                navbar.style.position = this.activeChatbot.id ? 'fixed' : '';
                            }

                            if (pageContentWrap && navbar?.offsetWidth > 0) {
                                pageContentWrap.style.paddingInlineStart = this.activeChatbot.id ? 'var(--navbar-width)' : '';
                            }

                            if (topNoticeBar) {
                                topNoticeBar.style.visibility = this.activeChatbot.id ? 'hidden' :
                                    '';
                            }

                            if (navbarExpander) {
                                navbarExpander.style.visibility = this.activeChatbot.id ? 'hidden' :
                                    '';
                                navbarExpander.style.opacity = this.activeChatbot.id ? 0 : 1;
                            }
                        }
                    },
                    async setEditingStep(step, skipCRUD = false) {
                        const prevStep = this.editingStep;
                        let editingStep = step;

                        if (step === '>') {
                            editingStep = Math.min(4, this.editingStep + 1);
                        } else if (step === '<') {
                            editingStep = Math.max(1, this.editingStep - 1);
                        }

                        if (
                            !skipCRUD &&
                            prevStep !== editingStep &&
                            prevStep === 1 &&
                            this.activeChatbot.id === 'new_chatbot'
                        ) {
                            await this.createNewChatbot();
                            return;
                        }

                        if (
                            !skipCRUD &&
                            prevStep !== editingStep &&
                            (prevStep === 2 || (prevStep === 1 && editingStep === 2)) &&
                            this.activeChatbot.id !== 'new_chatbot'
                        ) {
                            await this.updateChatbot();
                        }

                        if (
                            !skipCRUD &&
                            this.externalChatbotTraining != null &&
                            editingStep === 3 &&
                            this.activeChatbot.id !== 'new_chatbot'
                        ) {
                            this.externalChatbotTraining.fetchEmbeddings();
                        }

                        this.prevEditingStep = this.editingStep;
                        this.editingStep = editingStep;
                    },
                    async toggleChatbotActivation(chatbotId) {
                        const chatbot = this.chatbots.data.find(c => c.id === chatbotId);

                        if (!chatbot) return;

                        await this.updateChatbot(chatbot);
                    },
                    async deleteChatbot(event) {
                        if (!confirm(
                                '{{ __('Are you sure you want to delete this chatbot?') }}')) {
                            return;
                        }

                        const form = event.target;
                        const id = form.elements['id'].value;
                        const chatbotIndex = this.chatbots.data.findIndex(c => c.id == id);

                        this.submittinData = true;

                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: this.getFormData(this.chatbots.data.at(chatbotIndex))
                        });

                        if (!res.ok) {

                            const data = await res.json();

                            toastr.error(data.message);

                            return;
                        }

                        const data = await res.json();

                        if (data.type !== 'success') {
                            toastr.error(data.message);
                            return;
                        }

                        if (chatbotIndex !== -1) {
                            this.chatbots.data.splice(chatbotIndex, 1);
                        }

                        this.submittingData = false;

                        toastr.clear();
                        toastr.success(data.message ||
                            '{{ __('Chatbot deleted successfully') }}');
                    },
                    training: {
                        activeTab: 'website',
                        setActiveTab(tab) {
                            if (this.activeTab === tab) return;
                            this.activeTab = tab;
                        }
                    },
                    async createNewChatbot() {
                        this.submittingData = true;
                        this.formErrors = {};

                        const res = await fetch('{{ route('dashboard.chatbot.store') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                // 'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: this.getFormData()
                        });
                        const data = await res.json();
                        const {
                            data: chatbotData
                        } = data;

                        this.submittingData = false;

                        if (!res.ok || !chatbotData) {
                            if (data.errors) {
                                this.formErrors = data.errors;
                            } else if (data.message) {
                                toastr.error(data.message);
                            }

                            this.setEditingStep(1, true);
                            return;
                        }

                        this.chatbots.data.shift();

                        this.chatbots.data.unshift({
                            ...this.defaultFormInputs,
                            ...chatbotData
                        });

                        this.setActiveChatbot(chatbotData.id);
                        this.setEditingStep(2, true);
                        this.createNewChatObj();

                        toastr.clear();
                        toastr.success('{{ __('Chatbot created successfully') }}');
                    },
                    async updateChatbot(chatbot) {
                        this.submittingData = true;
                        this.formErrors = {};

                        const res = await fetch('{{ route('dashboard.chatbot.update') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                // Content-Type header'ını kaldırıyoruz, FormData kendi ayarlayacak
                            },
                            body: this.getFormData(chatbot)
                        });

                        const data = await res.json();
                        const {
                            data: chatbotData
                        } = data;

                        this.submittingData = false;

                        if (!res.ok || !chatbotData) {
                            if (data.errors) {
                                this.formErrors = data.errors;
                            } else if (data.message) {
                                toastr.error(data.message);
                            }
                            return;
                        }

                        const chatbotIndex = this.chatbots.data.findIndex(c => c.id === chatbotData.id);

                        if (chatbotIndex !== -1) {
                            this.chatbots.data[chatbotIndex] = {
                                ...this.chatbots.data[chatbotIndex],
                                ...chatbotData
                            };
                        }

                        toastr.clear();
                        toastr.success('{{ __('Chatbot updated successfully') }}');
                    },

                    onHumanAgentConditionsChange(event) {
                        const checkboxEl = event.currentTarget;
                        const conditionValue = checkboxEl.getAttribute('data-condition')?.trim();

                        if (!conditionValue) return;

                        if (!this.activeChatbot.human_agent_conditions) {
                            this.activeChatbot.human_agent_conditions = [];
                        }

                        const existingConditionIndex = this.activeChatbot.human_agent_conditions.findIndex(condition => condition === conditionValue);

                        if (checkboxEl.checked && existingConditionIndex === -1) {
                            this.activeChatbot.human_agent_conditions.push(conditionValue);
                        } else if (!checkboxEl.checked) {
                            this.activeChatbot.human_agent_conditions.splice(existingConditionIndex, 1);
                        }
                    },

                    getFormData(chatbot) {
                        const chatbotData = chatbot || this.activeChatbot;
                        const formData = new FormData();

                        Object.keys(chatbotData).forEach(key => {
                            const value = chatbotData[key];

                            // Dosya kontrolü
                            if (value instanceof File) {
                                formData.append(key, value);
                            }
                            // Array kontrolü (çoklu dosyalar için)
                            else if (Array.isArray(value)) {
                                value.forEach((item, index) => {
                                    if (item instanceof File) {
                                        formData.append(`${key}[${index}]`, item);
                                    } else {
                                        formData.append(`${key}[${index}]`, item);
                                    }
                                });
                            } else if (typeof value === 'boolean') {
                                formData.append(key, value ? 1 : 0);
                            }

                            // Null değerleri atla
                            else if (value !== null && value !== undefined) {
                                formData.append(key, value);
                            }
                        });

                        return formData;
                    }
                }));
            });
        })();
    </script>
@endpush
