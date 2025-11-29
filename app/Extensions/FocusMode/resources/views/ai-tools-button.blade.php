@php
    $classes = @twMerge('lqd-focus-mode-switch commander-icon-button commander-icon-button--focus relative hidden items-center justify-center hover:scale-95 hover:bg-transparent max-lg:size-10 max-lg:rounded-full max-lg:border max-lg:dark:bg-white/[3%] md:flex', $class);
    $commanderFocusGradient = uniqid('commander-focus-gradient-');
@endphp

<x-button
    :class="$classes"
    variant="link"
    href="#"
    title="{{ __('Focus Mode') }}"
    x-data="{}"
    @click.prevent="$store.focusMode.toggle()"
>
    <svg
        class="commander-icon commander-icon--focus"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="{{ $commanderFocusGradient }}" x1="5" y1="5" x2="19" y2="19" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#7b2ff7" />
                <stop offset="55%" stop-color="#00d4ff" />
                <stop offset="100%" stop-color="#00ff88" />
            </linearGradient>
        </defs>
        <circle
            cx="12"
            cy="12"
            r="6.5"
            stroke="url(#{{ $commanderFocusGradient }})"
            stroke-width="1.6"
            fill="rgba(10, 18, 45, 0.55)"
        />
        <circle
            cx="12"
            cy="12"
            r="2.2"
            fill="url(#{{ $commanderFocusGradient }})"
            fill-opacity="0.85"
        />
        <path
            d="M12 4V6.2"
            stroke="url(#{{ $commanderFocusGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
        />
        <path
            d="M12 17.8V20"
            stroke="url(#{{ $commanderFocusGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
        />
        <path
            d="M4 12H6.2"
            stroke="url(#{{ $commanderFocusGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
        />
        <path
            d="M17.8 12H20"
            stroke="url(#{{ $commanderFocusGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
    />
    </svg>
    <span
        class="duration-250 absolute start-1/2 top-1/2 inline-block h-[90%] w-[1.5px] -translate-x-1/2 -translate-y-1/2 rotate-0 scale-0 rounded bg-current transition-transform group-[&.focus-mode]/body:-rotate-45 group-[&.focus-mode]/body:scale-100"
        aria-hidden="true"
    ></span>
</x-button>
