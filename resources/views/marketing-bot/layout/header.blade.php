@php
    $menu_items = app(App\Services\Common\FrontMenuService::class)->generate();
@endphp

    <header
    class="modern-site-header bg-none group/header fixed inset-x-0 top-0 z-50 transition-all duration-300"
    x-data="{
        windowScrollY: window.scrollY,
        navbarHeight: $refs.navbar.offsetHeight,
        isScrolled: false,
        get sections() {
            return [...document.querySelectorAll('.site-section')].map(section => {
                const rect = section.getBoundingClientRect();
                return {
                    el: section,
                    rect: {
                        top: rect.top + this.windowScrollY,
                        bottom: rect.bottom + this.windowScrollY,
                        height: rect.height,
                    },
                    isDark: section.getAttribute('data-color-scheme') === 'dark'
                }
            })
        },
        checkColorScheme: function() {
            const sectionBehindNavbar = this.sections.find(section => {
                return (
                    section.rect.top <= this.windowScrollY + this.navbarHeight &&
                    section.rect.bottom >= this.windowScrollY + this.navbarHeight
                );
            });
            if (sectionBehindNavbar) {
                $el.classList.toggle('is-dark', sectionBehindNavbar.isDark)
            }
        },
        checkScroll() {
            this.windowScrollY = window.scrollY;
            this.isScrolled = window.scrollY > 20;
            $el.classList.toggle('header-scrolled', this.isScrolled);
        }
    }"
    x-init="checkColorScheme(); checkScroll();"
    @scroll.window="checkScroll"
    @scroll.window.throttle.50ms="checkColorScheme"
    @scroll.window.debounce.100ms="checkColorScheme"
>
    {{-- Preheader removed --}}
    {{-- @includeWhen($fSectSettings->preheader_active, 'landing-page.header.preheader') --}}

    <nav
        class="modern-site-nav bg-none relative z-10 py-4 transition-all duration-300 max-sm:py-3"
        id="frontend-local-navbar"
        x-ref="navbar"
    >
        <div class="container">
            <div
                class="modern-nav-container relative flex items-center justify-between rounded-2xl  px-6 py-4 transition-all duration-300 max-xl:gap-10 max-lg:gap-5 lg:px-5 lg:py-4"
                :class="{ 'header-scrolled': isScrolled }">

                <x-progressive-blur class=" h-full rounded-2xl" />

                <!-- Logo -->
                <a
                    class="modern-site-logo relative z-10 shrink-0 transition-transform duration-300 hover:scale-105"
                    href="{{ route('index') }}"
                >
                    @if (isset($setting->logo_dark))
                        <img
                            class="peer absolute start-0 top-1/2 -translate-y-1/2 h-8 opacity-0 transition-all duration-300 group-[.is-dark]/header:opacity-100 lg:h-10"
                            src="{{ custom_theme_url($setting->logo_dark_path, true) }}"
                            @if (isset($setting->logo_dark_2x_path)) srcset="/{{ $setting->logo_dark_2x_path }} 2x" @endif
                            alt="{{ custom_theme_url($setting->site_name) }} logo"
                        >
                    @endif
                    <img
                        class="h-8 transition-all duration-300 group-[.is-dark]/header:peer-first:opacity-0 lg:h-10"
                        src="{{ custom_theme_url($setting->logo_path, true) }}"
                        @if (isset($setting->logo_2x_path)) srcset="/{{ $setting->logo_2x_path }} 2x" @endif
                        alt="{{ $setting->site_name }} logo"
                    >
                </a>

                <!-- Navigation Menu -->
                <div
                    class="site-nav-container modern-nav-menu grow text-sm font-medium transition-all max-lg:absolute max-lg:start-0 max-lg:top-full max-lg:mt-2 max-lg:max-h-0 max-lg:w-full max-lg:overflow-hidden max-lg:rounded-2xl max-lg:shadow-lg max-lg:border lg:max-w-[60%] [&.lqd-is-active]:max-lg:max-h-[calc(100vh-150px)]">
                    <div class="max-lg:max-h-[inherit] max-lg:overflow-y-scroll max-lg:overscroll-contain max-lg:p-6">
                        <ul class="flex flex-col items-center justify-between gap-4 whitespace-nowrap text-center lg:flex-row lg:gap-6 xl:gap-8">
                            @php
                                $setting->menu_options = $setting->menu_options
                                    ? $setting->menu_options
                                    : '[{"title": "Home","url": "#banner","target": false},{"title": "Features","url": "#features","target": false},{"title": "How it Works","url": "#how-it-works","target": false},{"title": "Testimonials","url": "#testimonials","target": false},{"title": "Pricing","url": "#pricing","target": false},{"title": "FAQ","url": "#faq","target": false}]';
                                $menu_options = json_decode($setting->menu_options, true);
                            @endphp
                            @foreach ($menu_items as $menu_item)
                                @php
                                    $has_children = !empty($menu_item['mega_menu_id']);
                                @endphp
                                <li
                                    @class([
                                        'modern-nav-item group/li relative flex w-full items-center justify-between gap-2 after:pointer-events-none after:absolute after:-inset-x-4 after:bottom-[calc(var(--sub-offset,0)*-1)] after:top-full max-lg:flex-wrap lg:justify-center [&.is-hover]:after:pointer-events-auto',
                                        'has-children' => $has_children,
                                        'has-mega-menu' => !empty($menu_item['mega_menu_id']),
                                    ])
                                    x-data="{ hover: false }"
                                    x-on:mouseover="if(window.innerWidth < 992 ) return; hover = true"
                                    x-on:mouseleave="if(window.innerWidth < 992 ) return; hover = false"
                                    :class="{ 'is-hover': hover }"
                                >
                                    <a
                                        class="modern-nav-link group/link relative flex items-center justify-center gap-2 transition-all duration-200 max-lg:ps-2 [&.active]:font-medium [&.active]:text-modern-primary"
                                        href="{{ $menu_item['url'] }}"
                                        @if ($menu_item['target']) target="_blank" @endif
                                    >
                                        <svg
                                            class="pointer-events-none invisible absolute -start-3 top-1/2 shrink-0 -translate-y-1/2 translate-x-0 rotate-0 opacity-0 transition-all duration-200 group-hover/link:visible group-hover/link:-translate-x-2 group-hover/link:rotate-12 group-hover/link:opacity-100 group-[&.active]/link:visible group-[&.active]/link:-translate-x-2 group-[&.active]/link:rotate-12 group-[&.active]/link:opacity-100 max-lg:start-0"
                                            width="12"
                                            height="12"
                                            viewBox="0 0 13 12"
                                        >
                                            <use href="#menu-active-ind" />
                                        </svg>
                                        {{ __($menu_item['title']) }}
                                    </a>
                                    @if ($has_children)
                                        <span
                                            class="modern-nav-dropdown-toggle relative z-10 inline-grid size-9 shrink-0 place-content-center align-middle rounded-lg transition-all lg:hidden"
                                            style="color: hsl(var(--modern-foreground-muted));"
                                            @click="hover = !hover"
                                        >
                                            <x-tabler-chevron-down 
                                                class="size-4 transition-transform duration-200"
                                                x-bind:class="hover ? 'rotate-180' : ''"
                                            />
                                        </span>
                                    @endif
                                    @if (!empty($menu_item['mega_menu_id']))
                                        @includeFirst(['mega-menu::partials.frontend-megamenu', 'vendor.empty'], ['menu_item' => $menu_item])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if (count(explode(',', $settings_two->languages)) > 1)
                            <div class="modern-nav-languages group relative mt-6 block border-t py-5 md:hidden"
                                 style="border-color: rgba(255, 255, 255, 0.1);">
                                <p class="mb-3 flex items-center gap-2"
                                   style="color: #ffffff;">
                                    {{-- blade-formatter-disable --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" > <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M3.6 9h16.8"></path> <path d="M3.6 15h16.8"></path> <path d="M11.5 3a17 17 0 0 0 0 18"></path> <path d="M12.5 3a17 17 0 0 1 0 18"></path> </svg>
									{{-- blade-formatter-enable --}}
                                    {{ __('Languages') }}
                                </p>
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                        <a
                                            class="modern-nav-lang-link block py-2.5 transition-all duration-200 hover:translate-x-1"
                                            href="{{ route('language.change', $localeCode) }}"
                                            rel="alternate"
                                            hreflang="{{ $localeCode }}"
                                        >{{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }}
                                            {{ $properties['native'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions (Language, Auth Buttons, Mobile Menu) -->
                <div class="modern-nav-actions flex grow items-center justify-end gap-3">
                    @if (count(explode(',', $settings_two->languages)) > 1)
                        <div class="modern-language-switcher group relative hidden md:block">
                            <button
                                class="modern-icon-button relative inline-flex size-11 items-center justify-center rounded-xl border transition-all duration-200 hover:scale-105"
                                aria-label="{{ __('Languages') }}"
                            >
                                {{-- blade-formatter-disable --}}
								<svg class="relative z-1 size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" > <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M3.6 9h16.8"></path> <path d="M3.6 15h16.8"></path> <path d="M11.5 3a17 17 0 0 0 0 18"></path> <path d="M12.5 3a17 17 0 0 1 0 18"></path> </svg>
								{{-- blade-formatter-enable --}}
                            </button>
                            <div
                                class="modern-language-dropdown pointer-events-none absolute end-0 top-[calc(100%+0.75rem)] min-w-[160px] translate-y-2 rounded-2xl border shadow-lg opacity-0 transition-all duration-200 group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                        <a
                                            class="modern-dropdown-item block border-b px-4 py-3 transition-all duration-150 last:border-none"
                                            style="border-color: rgba(255, 255, 255, 0.1);"
                                            href="{{ route('language.change', $localeCode) }}"
                                            rel="alternate"
                                            hreflang="{{ $localeCode }}"
                                        >{{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }}
                                            {{ $properties['native'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @auth
                        <a
                            class="modern-button-secondary group relative inline-flex items-center whitespace-nowrap rounded-2xl border px-5 py-2.5 text-sm font-medium transition-all duration-200 hover:scale-105"
                            style="border-color: rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.1); color: #ffffff;"
                            href="{{ route('dashboard.index') }}"
                        >
                            <span class="relative z-10">
                                {!! __('Dashboard') !!}
                            </span>
                        </a>
                    @else
                        <a
                            class="modern-button-ghost group relative inline-flex items-center whitespace-nowrap rounded-2xl px-5 py-2.5 text-sm font-medium transition-all duration-200 hover:scale-105"
                            href="{{ route('login') }}"
                        >
                            <span class="relative z-10">
                                {!! __($fSetting->sign_in) !!}
                            </span>
                        </a>
                        <a
                            class="modern-button-primary group relative inline-flex items-center whitespace-nowrap rounded-2xl px-5 py-2.5 text-sm font-semibold transition-all duration-200 hover:scale-105"
                            href="{{ route('register') }}"
                        >
                            <span class="relative z-10">
                                {!! __($fSetting->join_hub) !!}
                            </span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button
                        class="mobile-nav-trigger modern-mobile-menu-toggle group relative z-10 flex size-11 shrink-0 items-center justify-center rounded-xl border transition-all duration-200 lg:hidden"
                        aria-label="{{ __('Menu') }}"
                    >
                        <span class="flex w-5 flex-col gap-1">
                            @for ($i = 0; $i <= 1; $i++)
                                <span
                                    class="inline-flex h-[2px] w-full transition-all duration-300 first:origin-left last:origin-right group-[&.lqd-is-active]:first:-translate-y-[2px] group-[&.lqd-is-active]:first:translate-x-[2px] group-[&.lqd-is-active]:first:rotate-45 group-[&.lqd-is-active]:last:-translate-x-[2px] group-[&.lqd-is-active]:last:-translate-y-[6px] group-[&.lqd-is-active]:last:-rotate-45"
                                ></span>
                            @endfor
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @includeWhen($fSetting->floating_button_active, 'landing-page.header.floating-button')
</header>

@includeWhen($app_is_demo, 'landing-page.header.envato-link')

@includeWhen(in_array($settings_two->chatbot_status, ['frontend', 'both']) &&
        ($settings_two->chatbot_login_require == false || ($settings_two->chatbot_login_require == true && auth()->check())),
    'panel.chatbot.widget',
    ['page' => 'landing-page']
)

<svg
    class="hidden"
    width="13"
    height="12"
    viewBox="0 0 13 12"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
>
    <path
        id="menu-active-ind"
        fill="currentColor"
        d="M6.19009 11.95C5.95767 10.6174 5.01249 8.94401 3.21509 7.59596C2.33189 6.92969 1.43319 6.49583 0.549988 6.30989V5.65911C2.3009 5.24075 4.02082 4.06315 5.12095 2.46719C5.67876 1.66146 6.03514 0.871223 6.19009 0.0499992H6.84087C7.10429 1.61497 8.31288 3.35039 9.95533 4.5125C10.7611 5.08581 11.5978 5.47318 12.45 5.65911V6.30989C10.7301 6.66628 8.73124 8.20026 7.73957 9.76523C7.24374 10.5555 6.94934 11.2837 6.84087 11.95H6.19009Z"
    />
</svg>
