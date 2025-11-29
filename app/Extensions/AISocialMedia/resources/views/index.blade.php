@php
    $steps_indicators = ['Platform', 'Company', 'Campaign', 'Content', 'Review', 'Publish'];
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Social Media'))
@section('titlebar_title')
    <span class="ai-social-media-page-title">
        {{ __('AI Social Media') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('Create and manage your social media posts') }}
@endsection
@section('titlebar_actions', '')

@section('additional_css')
    <link
        href="{{ custom_theme_url('assets/libs/select2/select2.min.css') }}"
        rel="stylesheet"
    />
    <style>
        .lds-dual-ring {
            display: inline-block;
            width: 20px;
            height: 20px;
            padding-top: 5px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 20px;
            height: 20px;
            margin: 0px;
            border-radius: 50%;
            border: 3px solid #7fa6f9;
            border-color: #7fa6f9 transparent #7fa6f9 transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* AI Social Media Page Background - Matching Chatbot Theme */
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
        #rocket-stars-ai-social-media {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
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

        /* Modern Card Styling */
        .ai-social-media-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Progress Bar Styling */
        .lqd-progress-bar {
            background: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 50%, #00ff88 100%) !important;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
        }

        /* Step Indicators Modern Styling */
        .step-indicator-active {
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
            border: 2px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3), inset 0 0 10px rgba(123, 47, 247, 0.2);
        }

        /* Step Progress Bar Border */
        .lqd-progress {
            background: rgba(255, 255, 255, 0.05) !important;
            border-radius: 10px;
        }

        /* Step Indicator Numbers */
        .step-indicator-number {
            transition: all 0.3s ease;
        }

        .step-indicator-number.bg-primary\/10 {
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
            border: 2px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3), inset 0 0 8px rgba(123, 47, 247, 0.2);
            color: rgba(0, 212, 255, 0.9) !important;
        }

        /* Step Indicator Text Styling */
        .step-indicator-text {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .step-indicator-text-inactive {
            color: rgba(255, 255, 255, 0.4);
        }

        /* Page Title Styling - Matching Chatbot Theme */
        .ai-social-media-page-title {
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

        /* Improved Font Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-page-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }

        /* Better Typography for Headings */
        body[data-theme="marketing-bot-dashboard"] .lqd-titlebar-title {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        /* Responsive Title */
        @media (max-width: 768px) {
            .ai-social-media-page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .ai-social-media-page-title {
                font-size: 1.75rem;
            }
        }

        /* Card Hover Effects - Enhanced */
        .ai-social-media-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }

        /* Card Rotating Background Effect */
        .ai-social-media-card::before {
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
            pointer-events: none;
        }

        .ai-social-media-card:hover::before {
            opacity: 1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* All Icons Modern Styling */
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card svg,
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card [class*="icon"],
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card .lqd-icon {
            filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.5));
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card:hover svg,
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card:hover [class*="icon"],
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card:hover .lqd-icon {
            filter: drop-shadow(0 0 15px rgba(0, 212, 255, 0.8));
            transform: scale(1.1);
        }

        /* Buttons Modern Styling */
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card .lqd-btn,
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card button {
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card .lqd-btn:hover,
        body[data-theme="marketing-bot-dashboard"] .ai-social-media-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }
    </style>
@endsection

@section('before-content-container')
    <div class="flex flex-col border-t">
        <div class="grid grid-flow-col overflow-x-auto text-sm font-semibold max-lg:[grid-template-columns:repeat(6,200px)] lg:grid-cols-6">
            @foreach ($steps_indicators as $step_indicator)
                <div @class([
                    'flex items-center justify-center gap-3 p-4',
                    'text-foreground/25' => $loop->index + 1 > $step,
                ])>
                    <span @class([
                        'size-9 inline-grid shrink-0 place-content-center rounded-full step-indicator-number',
                        'bg-primary/10 text-primary' => $loop->index + 1 <= $step,
                        'border border-foreground/10 text-foreground' => $loop->index + 1 > $step,
                    ])>
                        {{ $loop->index + 1 }}
                    </span>
                    <span @class([
                        'step-indicator-text' => $loop->index + 1 <= $step,
                        'step-indicator-text-inactive' => $loop->index + 1 > $step,
                    ])>
                        {{ __($step_indicator) }}
                    </span>
                    <x-tabler-chevron-right class="size-4" style="color: rgba(255, 255, 255, 0.3);" />
                </div>
            @endforeach
        </div>
        <div class="lqd-progress relative h-1.5 w-full bg-foreground/10">
            <div
                class="lqd-progress-bar absolute inset-0 rounded-full bg-gradient-to-br from-[#82E2F4] to-[#8A8AED]"
                style="width: {{ ($step / 6) * 100 }}%"
            ></div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-ai-social-media"></div>
    
    <div class="py-10 relative z-10">
        <x-card class="mx-auto w-full lg:w-5/12 ai-social-media-card">
            @includeFirst(['ai-social-media::steps.step-' . $step, 'panel.admin.custom.automation.steps.step-' . $step, 'vendor.empty'])
        </x-card>
    </div>

    @if ($setting->hosting_type != 'high')
        <input
            id="guest_id"
            type="hidden"
            value="{{ $apiUrl }}"
        >
        <input
            id="guest_event_id"
            type="hidden"
            value="{{ $apikeyPart1 }}"
        >
        <input
            id="guest_look_id"
            type="hidden"
            value="{{ $apikeyPart2 }}"
        >
        <input
            id="guest_product_id"
            type="hidden"
            value="{{ $apikeyPart3 }}"
        >
    @endif

@endsection

@push('script')
    <script>
        const stream_type = '{!! $settings_two->openai_default_stream_server !!}';
        const openai_model = '{{ $setting->openai_default_model }}';

        const guest_id = document.getElementById("guest_id")?.value;
        const guest_event_id = document.getElementById("guest_event_id")?.value;
        const guest_look_id = document.getElementById("guest_look_id")?.value;
        const guest_product_id = document.getElementById("guest_product_id")?.value;
    </script>

    <script src="{{ custom_theme_url('/assets/custom/custom_generate.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            var camSelect = $('select[name="camp_id"]');
            var camNameInput = $('#cam_injected_name');

            camSelect.on('change', function() {
                var selectedCam = $(this).val();
                var textTarget = $('textarea[name="camp_target"]');
                var selectedOptionText = $(this).find('option:selected').text();

                if (selectedCam != 0) {
                    $.get('/dashboard/user/automation/campaign/get-target/' + selectedCam, function(data) {}).done(function(data) {
                        textTarget.val(data);
                        camNameInput.val(selectedOptionText);
                    }).fail(function() {
                        textTarget.val('');
                        camNameInput.val('');
                    });
                }
            });

            camSelect.trigger('change');


            $('#compaignAddForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                $.post(url, data, function(data) {}).done(function(data) {
                    if (data) {
                        toastr.success('Campaign added successfully!');
                        window.location.reload();
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }).fail(function() {
                    toastr.error('Something went wrong!');
                });
            });

        });
    </script>
    <script>
        $('#add_btn').on('click', function(e) {
            $("#popover").addClass('popover__wrapper');
            $(".popover__back").removeClass("hidden");
            e.stopPropagation();
        })
        $(".popover__back").on('click', function() {
            $(this).addClass("hidden");
            $("#popover").removeClass('popover__wrapper');
        })

        function addNewTopic() {
            const textarea = document.getElementById('new_outline');
            const outlineText = textarea.value;
            const form = document.getElementById('stepsForm');
            const lines = outlineText.split('\n');
            const ul = document.querySelector('.select_outline ul');
            lines.forEach(function(line) {
                const trimmedLine = line.trim();
                if (trimmedLine.length > 0) {
                    const li = document.createElement('li');
                    li.textContent = trimmedLine;
                    ul.appendChild(li);

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'topics[]';
                    input.value = trimmedLine;
                    form.appendChild(input);
                }
            });
            textarea.value = '';
        }
    </script>

    <script>
        // Interactive Stars Background for AI Social Media Page
        let aiSocialMediaStars = [];
        let aiSocialMediaMouseX = 0;
        let aiSocialMediaMouseY = 0;
        
        function createAISocialMediaStars() {
            const starsContainer = document.getElementById('rocket-stars-ai-social-media');
            if (!starsContainer) return;
            
            const starCount = 100;
            aiSocialMediaStars = [];
            
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
                aiSocialMediaStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-ai-social-media');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                aiSocialMediaMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                aiSocialMediaMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateAISocialMediaStars();
            });
            
            // Initialize stars
            updateAISocialMediaStars();
        }
        
        function updateAISocialMediaStars() {
            aiSocialMediaStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = aiSocialMediaMouseX - starX;
                const dy = aiSocialMediaMouseY - starY;
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
            createAISocialMediaStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createAISocialMediaStars);
        } else {
            createAISocialMediaStars();
        }
    </script>
@endpush
