<x-card
    class:body="px-5 lg:px-10 py-6 lg:py-11 flex items-center flex-wrap gap-y-5 chatbot-stats-card"
    class="mb-9 chatbot-stats-card-wrapper"
>
    <div class="w-full shrink lg:basis-1/3">
        <p class="mb-0 font-heading text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-500 to-green-400">
            @lang('What's New.')
        </p>
    </div>

    <div class="w-full lg:basis-2/3">
        <div class="flex flex-col gap-y-4 md:flex-row">
            @php
                $isChatbotAgentRegistered = \App\Helpers\Classes\MarketplaceHelper::isRegistered('chatbot-agent');
            @endphp
            @if($isChatbotAgentRegistered)
                <a
                    class="group flex grow flex-col gap-1 border-b pb-4 text-heading-foreground transition-all md:border-b-0 md:border-e md:pb-0 md:pe-3 xl:px-10"
                    href="{{ route('dashboard.chatbot-agent.index') }}"
                >
                    <span class="group-hover:text-primary group-hover:underline">
                        {{ __('New Agent Messages') }}
                        <x-tabler-chevron-right class="ms-1 inline size-4 -translate-x-1 opacity-0 transition-all group-hover:translate-x-0 group-hover:opacity-100" />
                    </span>
                    <span class="flex font-heading text-[23px]/none font-semibold">
                        {{ $unreadAgentMessagesCount }}
                    </span>
                </a>
            @endif


            <a
                class="group flex grow flex-col gap-1 border-b pb-4 text-heading-foreground transition-all md:border-b-0 md:border-e md:px-3 md:pb-0 xl:px-10"
                href="#"
                @click.prevent="$store.externalChatbotHistory.setOpen(true)"
            >
                <span class="group-hover:text-primary group-hover:underline">
                    {{ __('New AI Messages') }}

                    <x-tabler-chevron-right class="ms-1 inline size-4 -translate-x-1 opacity-0 transition-all group-hover:translate-x-0 group-hover:opacity-100" />
                </span>
                <span class="flex font-heading text-[23px]/none font-semibold">
                    {{ $unreadAiBotMessagesCount }}
                </span>
            </a>

            <a
                class="group flex grow flex-col gap-1 pb-4 text-heading-foreground transition-all md:px-3 md:pb-0 xl:px-10"
                href="javascript:void(0)"
            >
                <span class="group-hover:text-primary group-hover:underline">
                    {{ __('Total Messages') }}
                    {{-- <x-tabler-chevron-right class="ms-1 inline size-4 -translate-x-1 opacity-0 transition-all group-hover:translate-x-0 group-hover:opacity-100" /> --}}
                </span>
                <span class="flex font-heading text-[23px]/none font-semibold">
                    {{ $allMessagesCount }}
                </span>
            </a>
        </div>
    </div>
</x-card>

<div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-11">
    {{-- Add new chatbot card --}}
    <x-card
        class:body="lg:p-16 p-9 chatbot-action-card create-chatbot-card"
        class="text-center chatbot-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full chatbot-icon-container create-icon">
            <div class="chatbot-icon-wrapper">
                <svg class="chatbot-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="createGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Speech bubble -->
                    <path d="M60 20 C40 20, 20 35, 20 60 C20 85, 40 100, 60 100 C80 100, 100 85, 100 60 C100 35, 80 20, 60 20 Z" 
                          fill="url(#createGradient)" 
                          opacity="0.9"
                          class="icon-glow"/>
                    <!-- Two dots (eyes) -->
                    <circle cx="45" cy="55" r="6" fill="white" opacity="0.9"/>
                    <circle cx="75" cy="55" r="6" fill="white" opacity="0.9"/>
                    <!-- Plus icon in center -->
                    <line x1="60" y1="70" x2="60" y2="85" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                    <line x1="50" y1="77.5" x2="70" y2="77.5" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Create and configure a chatbot that interacts with your users.')
        </p>
        <x-button
            @click.prevent="setActiveChatbot('new_chatbot', 1, true);"
            variant="ghost-shadow"
            href="#"
            class="chatbot-action-btn"
        >
            <x-tabler-plus class="size-4" />
            @lang('Add New Chatbot')
        </x-button>
    </x-card>

    {{-- Show history card --}}
    <x-card
        class:body="lg:p-16 p-9 chatbot-action-card explore-card"
        class="text-center chatbot-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full chatbot-icon-container explore-icon">
            <div class="chatbot-icon-wrapper">
                <svg class="chatbot-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="exploreGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Speech bubble -->
                    <path d="M60 20 C40 20, 20 35, 20 60 C20 85, 40 100, 60 100 C80 100, 100 85, 100 60 C100 35, 80 20, 60 20 Z" 
                          fill="url(#exploreGradient)" 
                          opacity="0.9"
                          class="icon-glow"/>
                    <!-- Three dots (typing indicator) -->
                    <circle cx="40" cy="55" r="5" fill="white" opacity="0.9" class="typing-dot" style="animation-delay: 0s"/>
                    <circle cx="60" cy="55" r="5" fill="white" opacity="0.9" class="typing-dot" style="animation-delay: 0.2s"/>
                    <circle cx="80" cy="55" r="5" fill="white" opacity="0.9" class="typing-dot" style="animation-delay: 0.4s"/>
                    <!-- Conversation lines -->
                    <line x1="35" y1="75" x2="85" y2="75" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.7"/>
                    <line x1="40" y1="85" x2="80" y2="85" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.5"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Explore recent conversations from your users.')
        </p>

        <div class="flex flex-wrap justify-center gap-x-3 gap-y-1">
            <x-button
                variant="ghost-shadow"
                href="#"
                @click.prevent="$store.externalChatbotHistory.setOpen(true)"
                class="chatbot-action-btn"
            >
                <x-tabler-robot
                    class="size-5"
                    stroke-width="1.5"
                />
                @lang('AI Bot Messages')
            </x-button>
            @if($isChatbotAgentRegistered)
                <x-button
                    variant="ghost-shadow"
                    href="{{ route('dashboard.chatbot-agent.index') }}"
                    class="chatbot-action-btn"
                >
                    <x-tabler-user
                        class="size-5"
                        stroke-width="1.5"
                    />
                    @lang('Agent Messages')
                </x-button>
            @endif
        </div>
    </x-card>
</div>