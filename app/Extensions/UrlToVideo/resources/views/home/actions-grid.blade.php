<div x-data="aiUrlToVideoData">
    {{-- Add new video card --}}
    <x-card
        class:body="lg:p-16 p-9 url-to-video-action-card"
        class="text-center url-to-video-action-card-wrapper"
    >
        <figure class="mx-auto mb-6 inline-grid size-40 place-items-center rounded-full url-to-video-icon-container">
            <div class="url-to-video-icon-wrapper">
                <svg class="url-to-video-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;">
                    <defs>
                        <linearGradient id="urlToVideoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#7b2ff7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00ff88;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Video camera icon -->
                    <rect x="25" y="30" width="70" height="50" rx="5" fill="url(#urlToVideoGradient)" opacity="0.9" class="icon-glow"/>
                    <circle cx="50" cy="55" r="8" fill="white" opacity="0.9"/>
                    <circle cx="70" cy="55" r="8" fill="white" opacity="0.9"/>
                    <!-- Plus icon -->
                    <line x1="60" y1="85" x2="60" y2="100" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                    <line x1="50" y1="92.5" x2="70" y2="92.5" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                </svg>
            </div>
        </figure>
        <p class="mx-auto mb-6 max-w-[370px] font-heading text-xl font-semibold leading-[1.3em] text-white">
            @lang('Generate an ad video using product URL or uploaded assets.')
        </p>
        <x-button
            variant="ghost-shadow"
            href="#"
            @click.prevent="toggleUrlToVideoWindow()"
            class="url-to-video-action-btn"
        >
            <x-tabler-plus class="size-4" />
            @lang('Generate New')
        </x-button>
    </x-card>

    @include('url-to-video::create-video.create-video-window', ['overlay' => true])
</div>

@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiUrlToVideoData', () => ({
                // use for refresh the data in url to video window
                createVideoWindowKey: 1,
                // status of url to video window
                openUrlToVideoWindow: false,
                init() {
                    Alpine.store('aiUrlToVideoData', this);
                },
                // toggle url to video window, open or close
                toggleUrlToVideoWindow(open = true) {
                    this.openUrlToVideoWindow = open;
                    if (open) {
                        this.createVideoWindowKey++;
                    }
                    Alpine.store('aiInflucencerData').toggleWindow(open);
                }
            }));
        });
    </script>
@endpush
