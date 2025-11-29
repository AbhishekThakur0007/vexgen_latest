<div
    class="group relative flex flex-wrap items-center justify-center gap-x-4 gap-y-7 overflow-hidden rounded-xl bg-gradient-to-r from-gradient-from/40 via-gradient-via/40 to-gradient-to/60 px-7 py-10 text-center dark:border dark:border-heading-foreground/10 dark:from-[rgba(186,255,219,0.07)] dark:via-[rgba(185,213,255,0.07)] dark:to-[rgba(228,188,252,0.07)] md:justify-start md:px-20 md:text-start">
    <div class="flex w-full flex-wrap items-center justify-center gap-x-7 gap-y-3 md:w-1/2 md:flex-nowrap md:justify-start">
        {{-- Modern Marketing Bot Icon --}}
        <div class="marketing-bot-icon-container">
            <svg class="marketing-bot-modern-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="marketingBotGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <!-- Megaphone/Broadcast icon -->
                <path d="M30 40 L30 80 L50 80 L70 100 L70 20 L50 40 Z" fill="url(#marketingBotGradient)" opacity="0.9" class="icon-glow"/>
                <!-- Sound waves -->
                <path d="M75 35 Q85 35, 85 45 Q85 55, 75 55" stroke="url(#marketingBotGradient)" stroke-width="4" fill="none" opacity="0.8"/>
                <path d="M75 25 Q95 25, 95 45 Q95 65, 75 65" stroke="url(#marketingBotGradient)" stroke-width="4" fill="none" opacity="0.6"/>
                <path d="M75 15 Q105 15, 105 45 Q105 75, 75 75" stroke="url(#marketingBotGradient)" stroke-width="4" fill="none" opacity="0.4"/>
            </svg>
        </div>
        <div class="!flex flex-nowrap items-center justify-center gap-2.5 group-hover:motion-preset-confetti">
            <div class="size-16">
                <img
                    class="h-full w-full object-cover"
                    src="{{ asset('vendor/marketing-bot/images/telegram_banner.png') }}"
                    alt="@lang('Like Image')"
                >
            </div>
            <div class="size-16">
                <img
                    class="h-full w-full object-cover"
                    src="{{ asset('vendor/marketing-bot/images/whatsapp_banner.png') }}"
                    alt="@lang('Like Image')"
                >
            </div>
        </div>
        <h3 class="m-0 grow xl:pe-24">
            {{ trans('Broadcast messages to your audience instantly on WhatsApp and Telegram.') }}
        </h3>
    </div>

    <div class="md:ms-auto">
        <x-button
            href="{{ route('dashboard.user.marketing-bot.settings.index') }}"
            variant="ghost-shadow"
        >
            <x-tabler-settings class="size-4" />
            {{ trans('Manage Settings') }}
        </x-button>
    </div>
</div>
