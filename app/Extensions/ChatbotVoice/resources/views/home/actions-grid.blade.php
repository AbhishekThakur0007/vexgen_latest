<div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-11">
    {{-- Add new chatbot card --}}
    <x-card
        class:body="lg:p-16 p-9"
        class="text-center voice-chatbot-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full voice-chatbot-icon-container create-voice-icon">
            <div class="voice-chatbot-icon-wrapper">
                <svg class="voice-chatbot-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="voiceCreateGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Microphone body -->
                    <rect x="45" y="30" width="30" height="50" rx="15" fill="url(#voiceCreateGradient)" opacity="0.9" class="icon-glow"/>
                    <!-- Microphone stand -->
                    <rect x="55" y="80" width="10" height="15" rx="5" fill="url(#voiceCreateGradient)" opacity="0.9"/>
                    <!-- Sound waves (left) -->
                    <path d="M 25 50 Q 15 50, 15 60 Q 15 70, 25 70" stroke="url(#voiceCreateGradient)" stroke-width="3" fill="none" opacity="0.7" stroke-linecap="round"/>
                    <path d="M 20 45 Q 5 45, 5 60 Q 5 75, 20 75" stroke="url(#voiceCreateGradient)" stroke-width="3" fill="none" opacity="0.5" stroke-linecap="round"/>
                    <!-- Sound waves (right) -->
                    <path d="M 95 50 Q 105 50, 105 60 Q 105 70, 95 70" stroke="url(#voiceCreateGradient)" stroke-width="3" fill="none" opacity="0.7" stroke-linecap="round"/>
                    <path d="M 100 45 Q 115 45, 115 60 Q 115 75, 100 75" stroke="url(#voiceCreateGradient)" stroke-width="3" fill="none" opacity="0.5" stroke-linecap="round"/>
                    <!-- Plus icon overlay -->
                    <circle cx="60" cy="55" r="8" fill="white" opacity="0.9"/>
                    <line x1="60" y1="50" x2="60" y2="60" stroke="url(#voiceCreateGradient)" stroke-width="2" stroke-linecap="round"/>
                    <line x1="55" y1="55" x2="65" y2="55" stroke="url(#voiceCreateGradient)" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Create AI voice chatbots that sound and behave just like a human.')
        </p>
        <x-button
            @click.prevent="setActiveChatbot('new_chatbot', 1, true);"
            variant="ghost-shadow"
            href="#"
            class="voice-chatbot-action-btn"
        >
            <x-tabler-plus class="size-4" />
            @lang('Add New Voice Chatbot')
        </x-button>
    </x-card>

    {{-- Show history card --}}
    <x-card
        class:body="lg:p-16 p-9"
        class="text-center voice-chatbot-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full voice-chatbot-icon-container history-icon">
            <div class="voice-chatbot-icon-wrapper">
                <svg class="voice-chatbot-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="voiceHistoryGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Chat bubble -->
                    <path d="M30 30 L90 30 Q100 30, 100 40 L100 70 Q100 80, 90 80 L50 80 L30 100 L30 80 Q20 80, 20 70 L20 40 Q20 30, 30 30 Z" 
                          fill="url(#voiceHistoryGradient)" 
                          opacity="0.9"
                          class="icon-glow"/>
                    <!-- Sound wave lines inside bubble -->
                    <path d="M 35 50 Q 40 45, 45 50 Q 50 55, 55 50" stroke="white" stroke-width="2" fill="none" opacity="0.9" stroke-linecap="round"/>
                    <path d="M 60 50 Q 65 45, 70 50 Q 75 55, 80 50" stroke="white" stroke-width="2" fill="none" opacity="0.9" stroke-linecap="round"/>
                    <!-- Time/clock icon overlay -->
                    <circle cx="85" cy="35" r="8" fill="white" opacity="0.9"/>
                    <circle cx="85" cy="35" r="6" stroke="url(#voiceHistoryGradient)" stroke-width="1.5" fill="none"/>
                    <line x1="85" y1="35" x2="85" y2="30" stroke="url(#voiceHistoryGradient)" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="85" y1="35" x2="88" y2="38" stroke="url(#voiceHistoryGradient)" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
        </figure>
        <p
            class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Explore recent conversations from your users.')
        </p>

        <div class="flex flex-wrap justify-center gap-x-3 gap-y-1">
            <x-button
                variant="ghost-shadow"
                href="#"
                @click.prevent="$store.externalChatbotHistory.setOpen(true)"
                class="voice-chatbot-action-btn"
            >
                <x-tabler-robot
                    class="size-5"
                    stroke-width="1.5"
                />
                @lang('AI Bot Messages')
            </x-button>
        </div>
    </x-card>
</div>
