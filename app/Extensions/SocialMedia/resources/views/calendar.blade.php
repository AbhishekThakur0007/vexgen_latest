@php
    $events = $items->map(function ($item) {
        $image = 'vendor/social-media/icons/' . $item->social_media_platform->value . '.svg';
        $image_dark = 'vendor/social-media/icons/' . $item->social_media_platform->value . '-light.svg';

        return [
            'title' => $item->social_media_platform->value,
            'date' => $item->scheduled_at->format('Y-m-d'),
            'classNames' => 'lqd-event-' . $item->social_media_platform->value,
            'extendedProps' => [
                'scheduled_at' => $item->scheduled_at->format('g:i a'),
                'content' => $item->content,
                'image' => $item->image,
                'platformImages' => [
                    'default' => asset($image),
                    'dark' => file_exists($image_dark) ? asset($image_dark) : null,
                ],
            ],
        ];
    });
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Calendar'))
@section('titlebar_title')
    <span class="social-calendar-page-title">
        {{ __('Calendar') }}
    </span>
@endsection
@section('titlebar_actions')
    @include('social-media::components.create-post-dropdown', ['platforms' => \App\Extensions\SocialMedia\System\Enums\PlatformEnum::cases()])
@endsection
@section('titlebar_subtitle', '')

@push('css')
    <style>
        /* Social Calendar Page Background - Matching Dashboard Theme */
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
        #rocket-stars-social-calendar {
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
        .social-calendar-page-title {
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
            .social-calendar-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .social-calendar-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Calendar Container */
        body[data-theme="marketing-bot-dashboard"] #calendar {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
            padding: 1rem !important;
            position: relative;
            z-index: 10;
        }
        
        /* FullCalendar Header */
        body[data-theme="marketing-bot-dashboard"] .fc-header-toolbar,
        body[data-theme="marketing-bot-dashboard"] .fc-toolbar {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            padding: 1rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-toolbar-title {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 700 !important;
        }
        
        /* FullCalendar Buttons */
        body[data-theme="marketing-bot-dashboard"] .fc-button,
        body[data-theme="marketing-bot-dashboard"] .fc-button-primary {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-button:hover,
        body[data-theme="marketing-bot-dashboard"] .fc-button-primary:hover {
            background: rgba(0, 212, 255, 0.2) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-button-active,
        body[data-theme="marketing-bot-dashboard"] .fc-button-primary:not(:disabled).fc-button-active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
        
        /* FullCalendar Table */
        body[data-theme="marketing-bot-dashboard"] .fc-theme-standard td,
        body[data-theme="marketing-bot-dashboard"] .fc-theme-standard th {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-col-header-cell {
            background: rgba(10, 14, 39, 0.6) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600 !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-daygrid-day {
            background: rgba(10, 14, 39, 0.4) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-daygrid-day:hover {
            background: rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-day-today {
            background: rgba(0, 212, 255, 0.15) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-daygrid-day-number {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-day-today .fc-daygrid-day-number {
            color: rgba(0, 212, 255, 1) !important;
            font-weight: 700 !important;
        }
        
        /* FullCalendar Events */
        body[data-theme="marketing-bot-dashboard"] .fc-event,
        body[data-theme="marketing-bot-dashboard"] .fc-event-main {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            border-radius: 0.5rem !important;
            padding: 0.25rem 0.5rem !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-event:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Event Content */
        body[data-theme="marketing-bot-dashboard"] .lqd-event-content {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-event-scheduled-at,
        body[data-theme="marketing-bot-dashboard"] .lqd-event-title {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Event Card/Tooltip */
        body[data-theme="marketing-bot-dashboard"] .lqd-event-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-event-card .lqd-card {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-event-card .lqd-card-body p {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Create Post Button */
        body[data-theme="marketing-bot-dashboard"] [class*="create-post"] button,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="create-post"] button:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* FullCalendar Popover */
        body[data-theme="marketing-bot-dashboard"] .fc-popover {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-popover-header {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .fc-popover-body {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-social-calendar"></div>
    
    <div class="py-10 relative z-10">
    <div class="py-10">
        {{-- @dump($items) --}}
        <div id="calendar"></div>
    </div>
@endsection

@push('script')
    <link
        href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css"
        rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    center: 'title',
                    end: 'today prev,next'
                },
                events: @json($events),
                eventContent: (arg) => {
                    return {
                        html: `<div class="lqd-event-content flex items-center gap-1.5 max-sm:justify-center">
							<figure class="lqd-event-platform-image shrink-0">
								${arg.event.extendedProps.platformImages.dark ? `<img width="28" height="28" class="hidden dark:block" src="${arg.event.extendedProps.platformImages.dark}" />` : ''}
								<img width="28" height="28" class="${arg.event.extendedProps.platformImages.dark ? 'dark:hidden' : ''}" src="${arg.event.extendedProps.platformImages.default}" />
							</figure>
							<div class="lqd-event-info grow">
								<div class="lqd-event-scheduled-at">${arg.event.extendedProps.scheduled_at}</div>
								<div class="lqd-event-title capitalize">${arg.event.title}</div>
							</div>

							<div class="lqd-event-card invisible absolute start-full -top-4 z-50 w-72 max-w-[100vw] translate-y-1 rounded-[10px] bg-background px-2.5 py-5 opacity-0 shadow-md shadow-black/5 transition-all max-sm:!start-1/2 max-sm:!top-1/2 max-sm:!end-auto max-sm:!bottom-auto max-sm:fixed max-sm:!-translate-x-1/2 max-sm:!-translate-y-1/2">
								<div class="lqd-card text-card-foreground w-full transition-all group/card lqd-card-outline border border-card-border lqd-card-roundness-default rounded-xl">
									<div class="lqd-card-head border-b border-card-border px-5 py-3.5 relative transition-border border-none pb-0">
										<figure>
											${arg.event.extendedProps.platformImages.dark ? `<img width="28" height="28" class="hidden dark:block" src="${arg.event.extendedProps.platformImages.dark}" />` : ''}
											<img width="28" height="28" class="${arg.event.extendedProps.platformImages.dark ? 'dark:hidden' : ''}" src="${arg.event.extendedProps.platformImages.default}" />
										</figure>
									</div>
									<div class="lqd-card-body relative only:grow lqd-card-md py-4 px-5">
										${arg.event.extendedProps.image ? `<figure class="mb-4 w-full"><img class="w-full rounded h-28 object-cover object-center" src="${arg.event.extendedProps.image}"></figure>` : ''}
										<p class="mb-0 max-h-24 overflow-hidden whitespace-normal text-ellipsis text-2xs/6 font-medium text-heading-foreground" style="mask-image: linear-gradient(to bottom, black 50%, transparent)">
											${arg.event.extendedProps.content}
										</p>
									</div>
								</div>
							</div>
					</div>`
                    }
                }
            });
            calendar.render();
        });
    </script>
    
    <script>
        // Interactive Stars Background for Social Calendar Page
        let socialCalendarStars = [];
        let socialCalendarMouseX = 0;
        let socialCalendarMouseY = 0;
        
        function createSocialCalendarStars() {
            const starsContainer = document.getElementById('rocket-stars-social-calendar');
            if (!starsContainer) return;
            
            const starCount = 100;
            socialCalendarStars = [];
            
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
                socialCalendarStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-social-calendar');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                socialCalendarMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                socialCalendarMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateSocialCalendarStars();
            });
            
            // Initialize stars
            updateSocialCalendarStars();
        }
        
        function updateSocialCalendarStars() {
            socialCalendarStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = socialCalendarMouseX - starX;
                const dy = socialCalendarMouseY - starY;
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
            createSocialCalendarStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createSocialCalendarStars);
        } else {
            createSocialCalendarStars();
        }
    </script>
@endpush
