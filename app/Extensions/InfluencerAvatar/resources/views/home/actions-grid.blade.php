<div x-data="InfluencerAvatarData">
    {{-- Add new product ad card --}}
    <x-card
        class:body="lg:p-16 p-9 influencer-action-card"
        class="text-center influencer-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full influencer-icon-container">
            <div class="influencer-icon-wrapper">
                <svg class="influencer-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;">
                    <defs>
                        <linearGradient id="influencerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Video camera icon -->
                    <rect x="25" y="30" width="70" height="50" rx="5" fill="url(#influencerGradient)" opacity="0.9" class="icon-glow"/>
                    <circle cx="50" cy="55" r="8" fill="white" opacity="0.9"/>
                    <circle cx="70" cy="55" r="8" fill="white" opacity="0.9"/>
                    <!-- Plus icon -->
                    <line x1="60" y1="85" x2="60" y2="100" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                    <line x1="50" y1="92.5" x2="70" y2="92.5" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Generate captivating video content with influencers.')
        </p>
        <x-button
            variant="ghost-shadow"
            href="#"
            @click.prevent="toggleInfluencerAvatarWindow()"
            class="influencer-action-btn"
        >
            <x-tabler-plus class="size-4" />
            @lang('Generate New')
        </x-button>
    </x-card>
    @include('influencer-avatar::social-video-window.social-video-window', ['overlay' => true])
</div>

@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('InfluencerAvatarData', () => ({
                // use for refresh the data in influencer avatar window
                influencerAvatarWindowKey: 1,
                // status of influencer avatar window
                openInfluencerAvatarWindow: false,
                init() {
                    Alpine.store('InfluencerAvatarData', this);
                },
                // toggle influencer avatar window, open or close
                toggleInfluencerAvatarWindow(open = true) {
                    this.openInfluencerAvatarWindow = open;
                    if (open) {
                        this.influencerAvatarWindowKey++;
                    }
                    Alpine.store('aiInflucencerData').toggleWindow(open);
                }
            }));
        });
    </script>
@endpush
