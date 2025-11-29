@php($commanderThemeGradient = uniqid('commander-theme-gradient-'))

<x-button
    {{ $attributes->twMerge('lqd-light-dark-switch commander-icon-button commander-icon-button--theme flex items-center justify-center max-lg:size-10 max-lg:rounded-full max-lg:border max-lg:dark:bg-white/[3%]') }}
    size="none"
    href="#"
    title="{{ __('Toggle dark/light') }}"
    variant="link"
    x-data="{}"
    @click.prevent="$store.darkMode.toggle()"
>
    <svg
        class="commander-icon commander-icon--sun hidden dark:inline-flex"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="{{ $commanderThemeGradient }}-sun" x1="6" y1="5" x2="18" y2="19" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#7b2ff7" />
                <stop offset="55%" stop-color="#00d4ff" />
                <stop offset="100%" stop-color="#00ff88" />
            </linearGradient>
        </defs>
        <circle cx="12" cy="12" r="4.5" fill="url(#{{ $commanderThemeGradient }}-sun)" fill-opacity="0.85" />
        <path d="M12 4V2" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M12 22V20" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M4 12H2" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M22 12H20" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M5.6 5.6L4.2 4.2" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M19.8 19.8L18.4 18.4" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M18.4 5.6L19.8 4.2" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
        <path d="M4.2 19.8L5.6 18.4" stroke="url(#{{ $commanderThemeGradient }}-sun)" stroke-width="1.6" stroke-linecap="round" />
    </svg>
    <svg
        class="commander-icon commander-icon--moon dark:hidden"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="{{ $commanderThemeGradient }}-moon" x1="7" y1="4" x2="19" y2="18" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#7b2ff7" />
                <stop offset="55%" stop-color="#00d4ff" />
                <stop offset="100%" stop-color="#00ff88" />
            </linearGradient>
        </defs>
        <path
            d="M12.2 3.5C9.5 4.3 7.5 6.8 7.5 9.8C7.5 13.7 10.7 16.9 14.6 16.9C16 16.9 17.3 16.5 18.4 15.8C17.3 19 14.3 21.5 10.7 21.5C6.1 21.5 2.4 17.8 2.4 13.2C2.4 9 5.4 5.5 9.4 4.7C10.3 4.5 11.3 4.4 12.2 4.4"
            stroke="url(#{{ $commanderThemeGradient }}-moon)"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
            fill="rgba(10, 18, 45, 0.55)"
    />
        <circle cx="16.8" cy="6.4" r="1.1" fill="#7b2ff7" />
        <circle cx="18.9" cy="9.5" r="0.9" fill="#00d4ff" />
    </svg>
</x-button>
