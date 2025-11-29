<div x-data="aiViralClipsData">
    {{-- Add new product ad card --}}
    <x-card
        class:body="lg:p-16 p-9 ai-viral-clips-action-card"
        class="text-center ai-viral-clips-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full ai-viral-clips-icon-container">
            <div class="ai-viral-clips-icon-wrapper">
                <svg class="ai-viral-clips-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;">
                    <defs>
                        <linearGradient id="viralClipsGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Video clip icon -->
                    <rect x="20" y="30" width="80" height="60" rx="5" fill="url(#viralClipsGradient)" opacity="0.9" class="icon-glow"/>
                    <circle cx="40" cy="60" r="6" fill="white" opacity="0.9"/>
                    <circle cx="60" cy="60" r="6" fill="white" opacity="0.9"/>
                    <circle cx="80" cy="60" r="6" fill="white" opacity="0.9"/>
                    <!-- Scissors icon for clips -->
                    <path d="M30 85 L50 85 M40 75 L40 95" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
                    <path d="M70 85 L90 85 M80 75 L80 95" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Generate viral clips from long video content.')
        </p>
        <x-button
            variant="ghost-shadow"
            href="#"
            @click.prevent="toggleAiClipsWindow()"
            class="ai-viral-clips-action-btn"
        >
            <x-tabler-plus class="size-4" />
            @lang('Generate New')
        </x-button>
    </x-card>
    @include('ai-viral-clips::create-clips.create-clips-window', ['overlay' => true])
</div>

@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiViralClipsData', () => ({
                // use for refresh the data in ai viral clips window
                aiClipsWindowKey: 1,
                // status of ai clips window
                openAiClipsWindow: false,
                init() {
                    Alpine.store('aiViralClipsData', this);
                },
                // toggle ai clips window, open or close
                toggleAiClipsWindow(open = true) {
                    this.openAiClipsWindow = open;
                    if (open) {
                        this.aiClipsWindowKey++;
                    }
                    Alpine.store('aiInflucencerData').toggleWindow(open);
                }
            }));
        });
    </script>
@endpush
