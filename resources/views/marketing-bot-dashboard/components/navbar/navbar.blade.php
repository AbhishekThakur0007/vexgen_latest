<a
    class="lqd-skip-link pointer-events-none fixed start-7 top-7 z-[9999] rounded-md bg-background px-3 py-1 text-lg opacity-0 shadow-xl focus-visible:pointer-events-auto focus-visible:opacity-100 focus-visible:outline-primary"
    href="#lqd-titlebar"
>
    {{ __('Skip to content') }}
</a>

<aside
    class="lqd-navbar commander-sidebar max-lg:rounded-b-5 start-0 top-0 z-[99] w-[--navbar-width] shrink-0 overflow-hidden rounded-ee-navbar-ee rounded-es-navbar-es rounded-se-navbar-se rounded-ss-navbar-ss border-r border-[#00d4ff]/20 bg-gradient-to-b from-[#0a1a2d] via-[#1a2b4d] to-[#0f1e35] text-navbar font-medium text-navbar-foreground transition-[width,transform,opacity] duration-300 ease-in-out max-lg:invisible max-lg:absolute max-lg:left-0 max-lg:top-[65px] max-lg:z-[99] max-lg:max-h-[calc(85vh-2rem)] max-lg:min-h-0 max-lg:w-full max-lg:origin-top max-lg:-translate-y-2 max-lg:scale-95 max-lg:overflow-y-auto max-lg:bg-background max-lg:p-0 max-lg:opacity-0 max-lg:shadow-xl lg:fixed lg:bottom-0 lg:top-0 lg:border-e max-lg:[&.lqd-is-active]:visible max-lg:[&.lqd-is-active]:translate-y-0 max-lg:[&.lqd-is-active]:scale-100 max-lg:[&.lqd-is-active]:opacity-100 relative"
    x-init
    :class="{ 'lqd-is-active': !$store.mobileNav.navCollapse }"
    @click.outside="$store.navbarShrink.toggle('shrink')"
    @mouseleave="$store.navbarShrink.toggle('shrink')"
>
    {{-- Interactive Starfield Background --}}
    <div class="commander-sidebar-stars absolute inset-0 overflow-hidden pointer-events-none z-0" id="sidebar-starfield"></div>
    <div
        class="lqd-navbar-inner -me-navbar-me h-full overflow-y-auto overscroll-contain pe-navbar-pe ps-navbar-ps lg:group-[&.navbar-shrinked]/body:flex lg:group-[&.navbar-shrinked]/body:flex-col lg:group-[&.navbar-shrinked]/body:items-center lg:group-[&.navbar-shrinked]/body:justify-between relative z-10">
        <button
            class="lqd-navbar-expander group/expander !visible relative flex cursor-pointer flex-col items-center gap-1.5 p-0 text-center text-4xs font-medium !opacity-100 transition-opacity duration-200 ease-in-out max-lg:hidden"
            x-init
            @click.prevent="$store.navbarShrink.toggle()"
        >
            <span class="inline-grid place-items-center">
                <x-tabler-grid-dots
                    class="col-start-1 col-end-1 row-start-1 row-end-1 size-5 shrink-0"
                    x-show="$store.navbarShrink.active"
                />
                <x-tabler-x
                    class="col-start-1 col-end-1 row-start-1 row-end-1 size-5 shrink-0"
                    x-cloak
                    x-show="!$store.navbarShrink.active"
                />
            </span>
            <span
                class="transition"
                :class="{ 'opacity-0': !$store.navbarShrink.active }"
            >
                {{ __('Menu') }}
            </span>
        </button>

        @php
            $items = app(\App\Services\Common\MenuService::class)->generate();
            $isAdmin = \Auth::user()?->isAdmin();
        @endphp

        <div class="hidden w-full grow flex-col items-center pb-5 pt-3.5 lg:group-[&.navbar-shrinked]/body:flex">
            @php
                $middle_nav_urls = app(\App\Services\Common\MenuService::class)->boltMenu();
                $bottom_nav_urls = ['support', 'settings', 'affiliates'];
                $middle_nav_items = [];
                $bottom_nav_items = [];

                foreach ($items as $key => $item) {
                    if (in_array($key, array_keys($middle_nav_urls))) {
                        $middle_nav_items[$key] = $item;
                    } elseif (in_array($key, $bottom_nav_urls)) {
                        $bottom_nav_items[$key] = $item;
                    }
                }
            @endphp
            <nav class="flex w-full grow flex-col">
                <ul class="flex flex-col gap-3.5">
                    @foreach ($middle_nav_items as $key => $item)
                        {{-- <style>
                            #{{ $key }} {
                                --background: {{ $middle_nav_urls[$key]['background'] }};
                                --foreground: {{ $middle_nav_urls[$key]['foreground'] }};
                            }
                        </style> --}}
                        @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                            @if (data_get($item, 'is_admin'))
                                @if ($isAdmin)
                                    @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                        @if ($item['children_count'])
                                            @includeIf('default.components.navbar.partials.types.item-dropdown')
                                        @else
                                            @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                    @if ($item['children_count'])
                                        @includeIf('default.components.navbar.partials.types.item-dropdown')
                                    @else
                                        @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endforeach
                </ul>

                <div class="mt-auto flex flex-col items-center">
                    <ul class="lqd-navbar-ul-focus-bottom flex w-full flex-col gap-3.5">
                        @foreach ($bottom_nav_items as $key => $item)
                            @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                                @if (data_get($item, 'is_admin'))
                                    @if ($isAdmin)
                                        @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                            @if ($item['children_count'])
                                                @includeIf('default.components.navbar.partials.types.item-dropdown')
                                            @else
                                                @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                        @if ($item['children_count'])
                                            @includeIf('default.components.navbar.partials.types.item-dropdown')
                                        @else
                                            @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>

        <nav
            class="lqd-navbar-nav commander-menu-nav lg:group-[&.navbar-shrinked]/body:hidden relative z-10"
            id="navbar-menu"
        >
            <ul class="lqd-navbar-ul">
                @foreach ($items as $key => $item)
                    @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                        @if (data_get($item, 'is_admin'))
                            @if ($isAdmin)
                                @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                    @if ($item['children_count'])
                                        @includeIf('default.components.navbar.partials.types.item-dropdown')
                                    @else
                                        @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                    @endif
                                @endif
                            @endif
                        @else
                            @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                @if ($item['children_count'])
                                    @includeIf('default.components.navbar.partials.types.item-dropdown')
                                @else
                                    @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach

                {{-- Admin menu items --}}
                @if ($isAdmin)
                    {{-- <x-navbar.item>
                        <x-navbar.link
                            label="{{ __('ChatBot') }}"
                            href="dashboard.chatbot.index"
                            icon="tabler-message-2-code"
                            active-condition="{{ activeRoute('dashboard.chatbot.*') }}"
                            new
                        />
                    </x-navbar.item> --}}

                    @if ($app_is_not_demo && setting('premium_support', true) && !\App\Helpers\Classes\Helper::isUserVIP())
                        <x-navbar.item>
                            <x-navbar.link
                                label="{{ __('Premium Membership') }}"
                                href="#"
                                trigger-type="modal"
                            >
                                <x-slot:modal>
                                    @includeIf('premium-support.index')
                                </x-slot:modal>
                            </x-navbar.link>
                        </x-navbar.item>
                    @endif
                @endif

                <x-navbar.item>
                    <x-navbar.divider />
                </x-navbar.item>

                <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                    <x-navbar.label>
                        {{ __('Credits') }}
                    </x-navbar.label>
                </x-navbar.item>

                <x-navbar.item class="pb-navbar-link-pb pe-navbar-link-pe ps-navbar-link-ps pt-navbar-link-pt group-[&.navbar-shrinked]/body:hidden">
                    <x-credit-list />
                </x-navbar.item>

                @if ($setting->feature_affilates)
                    <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                        <x-navbar.divider />
                    </x-navbar.item>

                    <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                        <x-navbar.label>
                            {{ __('Affiliation') }}
                        </x-navbar.label>
                    </x-navbar.item>

                    <x-navbar.item class="pb-navbar-link-pb pe-navbar-link-pe ps-navbar-link-ps pt-navbar-link-pt group-[&.navbar-shrinked]/body:hidden">
                        <div
                            class="lqd-navbar-affiliation inline-block w-full rounded-xl border border-navbar-divider px-8 py-4 text-center text-2xs leading-tight transition-border">
                            <p class="m-0 mb-2 text-[20px] not-italic">🎁</p>
                            <p class="mb-4">{{ __('Invite your friend and get') }}
                                {{ $setting->affiliate_commission_percentage }}%
                                @if ($is_onetime_commission)
                                    {{ __('on their first purchase.') }}
                                @else
                                    {{ __('on all their purchases.') }}
                                @endif
                            </p>
                            <x-button
                                class="text-3xs"
                                href="{{ route('dashboard.user.affiliates.index') }}"
                                variant="ghost-shadow"
                            >
                                {{ __('Invite') }}
                            </x-button>
                        </div>
                    </x-navbar.item>
                @endif
            </ul>
        </nav>
    </div>
</aside>

<script>
    // Interactive Starfield with Mouse Movement - Optimized
    document.addEventListener('DOMContentLoaded', function() {
        const starfield = document.getElementById('sidebar-starfield');
        if (!starfield) return;
        
        const starCount = 60; // Reduced from 80 for better performance
        const stars = [];
        let mouseX = 50;
        let mouseY = 50;
        let rafId = null;
        let isTransitioning = false;
        let lastUpdateTime = 0;
        const throttleDelay = 16; // ~60fps
        
        // Create stars
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'interactive-star';
            const size = Math.random() * 2 + 1;
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            const duration = Math.random() * 3 + 2;
            const delay = Math.random() * 2;
            
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
                transition: opacity 0.2s ease, transform 0.2s ease;
                pointer-events: none;
                will-change: opacity, transform;
            `;
            
            star.dataset.x = x;
            star.dataset.y = y;
            star.dataset.baseOpacity = star.style.opacity;
            star.dataset.baseSize = size;
            
            starfield.appendChild(star);
            stars.push(star);
        }
        
        // Track mouse movement on sidebar with throttling
        const sidebar = starfield.closest('.commander-sidebar');
        if (sidebar) {
            let pendingUpdate = false;
            
            sidebar.addEventListener('mousemove', function(e) {
                if (isTransitioning) return;
                
                const rect = sidebar.getBoundingClientRect();
                mouseX = ((e.clientX - rect.left) / rect.width) * 100;
                mouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                if (!pendingUpdate) {
                    pendingUpdate = true;
                    requestAnimationFrame(() => {
                        updateStars();
                        pendingUpdate = false;
                    });
                }
            }, { passive: true });
            
            sidebar.addEventListener('mouseleave', function() {
                mouseX = 50;
                mouseY = 50;
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }
                updateStars();
            });
            
            // Pause starfield during sidebar transitions
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const hasShrinked = document.body.classList.contains('navbar-shrinked');
                        isTransitioning = true;
                        
                        // Pause updates during transition
                        if (rafId) {
                            cancelAnimationFrame(rafId);
                            rafId = null;
                        }
                        
                        // Resume after transition completes
                        setTimeout(() => {
                            isTransitioning = false;
                        }, 300); // Match transition duration
                    }
                });
            });
            
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
        
        function updateStars() {
            if (isTransitioning) return;
            
            const currentTime = performance.now();
            if (currentTime - lastUpdateTime < throttleDelay) {
                if (!rafId) {
                    rafId = requestAnimationFrame(() => {
                        updateStars();
                    });
                }
                return;
            }
            lastUpdateTime = currentTime;
            
            stars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = mouseX - starX;
                const dy = mouseY - starY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                // Calculate intensity based on distance (closer = brighter)
                const maxDistance = 50;
                const intensity = Math.max(0, 1 - (distance / maxDistance));
                
                // Update star properties
                const baseOpacity = parseFloat(star.dataset.baseOpacity);
                const baseSize = parseFloat(star.dataset.baseSize);
                
                const newOpacity = Math.min(1, baseOpacity + intensity * 0.7);
                const newSize = baseSize + intensity * 2;
                const glowSize = newSize * 3;
                
                // Use transform for better performance
                star.style.opacity = newOpacity;
                star.style.width = newSize + 'px';
                star.style.height = newSize + 'px';
                star.style.boxShadow = `
                    0 0 ${glowSize}px rgba(0, 212, 255, ${0.6 + intensity * 0.4}),
                    0 0 ${glowSize * 2}px rgba(123, 47, 247, ${0.4 + intensity * 0.3}),
                    0 0 ${glowSize * 3}px rgba(0, 255, 136, ${intensity * 0.2})
                `;
                
                // Add slight movement towards mouse
                const moveX = dx * 0.1;
                const moveY = dy * 0.1;
                star.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
            
            rafId = null;
        }
        
        // Initialize stars
        updateStars();
    });
</script>

<style>
    /* Interactive Starfield */
    .commander-sidebar-stars {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 1;
        background: 
            radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(123, 47, 247, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(0, 255, 136, 0.05) 0%, transparent 60%);
    }
    
    .interactive-star {
        position: absolute;
        border-radius: 50%;
        background: white;
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
        will-change: opacity, transform;
        transform: translateZ(0); /* Force hardware acceleration */
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
</style>
