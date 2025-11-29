@php
    $commanderUser = auth()->user();
@endphp

<header class="lqd-header relative flex h-[--header-height] text-xs font-medium transition-colors max-lg:h-[65px]">
    <div @class([
        'lqd-header-container flex w-full grow gap-2 px-4 max-lg:w-full max-lg:max-w-none',
        'container' => !$attributes->get('layout-wide'),
        'container-fluid' => $attributes->get('layout-wide'),
        Theme::getSetting('wideLayoutPaddingX', '') =>
            filled(Theme::getSetting('wideLayoutPaddingX', '')) &&
            $attributes->get('layout-wide'),
    ])>
        <x-rocket-logo class="max-lg:hidden" />

        {{-- Mobile nav toggle and logo --}}
        <div class="mobile-nav-logo flex items-center gap-3 lg:hidden">
            <button
                class="lqd-mobile-nav-toggle flex size-10 items-center justify-center"
                type="button"
                x-init
                @click.prevent="$store.mobileNav.toggleNav()"
                :class="{ 'lqd-is-active': !$store.mobileNav.navCollapse }"
            >
                <span class="lqd-mobile-nav-toggle-icon relative h-[2px] w-5 rounded-xl bg-current"></span>
            </button>
            <x-rocket-logo />
        </div>

        {{-- Title slot --}}
        @if ($title ?? false)
            <div class="header-title-container peer/title hidden items-center lg:flex">
                <h1 class="m-0 font-semibold">
                    {{ $title }}
                </h1>
            </div>
        @endif

        @includeFirst(['focus-mode::header', 'components.includes.ai-tools', 'vendor.empty'])

        <div class="header-actions-container flex grow justify-end gap-4 max-lg:basis-2/3 max-lg:gap-2">
            {{-- Action buttons --}}
            @if ($actions ?? false)
                {{ $actions }}
            @else
                <div class="flex items-center max-xl:gap-2 max-lg:hidden xl:gap-5">
                    @if (Auth::user()->isAdmin())
						<x-update-available />
                        <x-button
                            href="{{ route('dashboard.admin.index') }}"
                            variant="link"
                        >
                            {{ __('Admin Panel') }}
                        </x-button>
                    @endif

                    @if (Auth::user()->isAdmin())
						@if ($app_is_not_demo)
							{{-- Upgrade button --}}
							<x-modal
								class="max-lg:hidden"
								type="page"
							>
								<x-slot:trigger
									custom
								>
									<x-button
										class="lqd-header-upgrade-btn flex items-center justify-center p-0 text-current"
										href="#"
										variant="link"
										title="{{ __('Premium Membership') }}"
										@click.prevent="toggleModal()"
									>
										<x-tabler-diamond class="size-5" />
										{{ __('Upgrade') }}
									</x-button>
								</x-slot:trigger>
								<x-slot:modal>
									@includeIf('premium-support.index')
								</x-slot:modal>
							</x-modal>
						@else
							<x-button
								class="lqd-header-upgrade-btn flex items-center justify-center p-0 text-current"
								href="{{ route('dashboard.user.payment.subscription') }}"
								variant="link"
							>
								<x-tabler-diamond class="size-5" />
								{{ __('Upgrade') }}
							</x-button>
						@endif
                    @endif
                </div>
            @endif

            <span class="hidden h-4 w-px self-center bg-border transition-colors lg:inline-block"></span>

            <div class="flex items-center gap-4 max-lg:gap-2">
                @includeIf('marketing-bot::header.inbox-notification')

                <x-header-search
                    class="max-lg:hidden"
                    style="modern"
                    :show-icon="true"
                />

                {{-- Dark/light switch --}}
                @if (Theme::getSetting('dashboard.supportedColorSchemes') === 'all')
                    <x-light-dark-switch />
                @endif

                @includeFirst(['focus-mode::ai-tools-button', 'components.includes.ai-tools-button', 'vendor.empty'])

                @if (setting('notification_active', 0))
                    {{-- Notifications --}}
                    <x-notifications />
                @endif

                {{-- Language dropdown --}}
                @if (count(explode(',', $settings_two->languages)) > 1)
                    <x-language-dropdown />
                @endif

                <x-button
                    class="commander-icon-button commander-icon-button--gift text-foreground max-lg:hidden"
                    href="{{ route('dashboard.user.affiliates.index') }}"
                    hover-variant="primary"
                    size="none"
                >
                    <span class="sr-only">
                        {{ __('Affiliate Program') }}
                    </span>
                    @php($commanderGiftGradient = uniqid('commander-gift-gradient-'))
                    <svg
                        class="commander-icon commander-icon--gift"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <defs>
                            <linearGradient id="{{ $commanderGiftGradient }}" x1="3" y1="4" x2="21" y2="20" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#7b2ff7" />
                                <stop offset="55%" stop-color="#00d4ff" />
                                <stop offset="100%" stop-color="#00ff88" />
                            </linearGradient>
                        </defs>
                        <rect
                            x="4"
                            y="9"
                            width="16"
                            height="11"
                            rx="3"
                            stroke="url(#{{ $commanderGiftGradient }})"
                            stroke-width="1.6"
                            fill="rgba(10, 18, 45, 0.6)"
                        />
                        <path
                            d="M4 12.5H20"
                            stroke="url(#{{ $commanderGiftGradient }})"
                            stroke-width="1.6"
                            stroke-linecap="round"
                        />
                        <path
                            d="M12 9V20"
                            stroke="url(#{{ $commanderGiftGradient }})"
                            stroke-width="1.6"
                            stroke-linecap="round"
                        />
                        <path
                            d="M7.2 7.4C5.9 6 6.4 4 8.2 4C9.5 4 10.3 5 11.3 6.4C12 7.4 12.7 8.4 13.6 8.4C15.4 8.4 16.1 6.1 14.2 4.9C13.3 4.3 12.3 4.3 11.3 4.6"
                            stroke="url(#{{ $commanderGiftGradient }})"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <circle cx="8.7" cy="14.3" r="0.85" fill="#7b2ff7" />
                        <circle cx="15.5" cy="14.3" r="0.85" fill="#00d4ff" />
                        <circle cx="12" cy="17.8" r="0.95" fill="#00ff88" />
                    </svg>
                </x-button>

                {{-- User menu --}}
                <x-user-dropdown class="commander-user-dropdown">
                    <x-slot:trigger class="size-11 p-0">
                        <span class="commander-user-orb" aria-hidden="true">
                            <span class="commander-user-orb__pulse"></span>
                            <span class="commander-user-orb__halo"></span>
                            <x-tabler-user class="commander-user-orb__icon" />
                        </span>
                        <span class="sr-only">
                            {{ __('Open user menu for :name', ['name' => $commanderUser?->name ?? $commanderUser?->email ?? __('your account')]) }}
                        </span>
                    </x-slot:trigger>
                </x-user-dropdown>
            </div>
        </div>
    </div>
</header>
