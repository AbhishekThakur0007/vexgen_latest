<section
    class="site-section relative grid min-h-screen place-content-center pb-20 pt-40 lg:pb-28 lg:pt-44"
    id="banner"
    data-color-scheme="dark"
>
    <!-- Rotating Globe Animation -->
    <div style="width: 179px; height: 759px;" class="modern-banner-globe"></div>

    <!-- AI Animation Layer -->
    <div class="modern-banner-ai-layer">
        <!-- Floating Particles -->
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        <div class="modern-banner-particle"></div>
        
        <!-- Neural Network Connections -->
        <div class="modern-banner-connection"></div>
        <div class="modern-banner-connection"></div>
        <div class="modern-banner-connection"></div>
        <div class="modern-banner-connection"></div>
        
        <!-- Data Streams -->
        <div class="modern-banner-stream"></div>
        <div class="modern-banner-stream"></div>
        <div class="modern-banner-stream"></div>
    </div>

    <div class="modern-banner-container container relative">
        <div class="modern-banner-content">
            <!-- Main Headline -->
            <h1 class="modern-banner-headline translate-y-7 opacity-0 transition-all delay-150 ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                <span>Build. Automate. Grow.</span>
                <span>— Your All-in-One AI Workspace.</span>
            </h1>

            <!-- Sub-headline -->
            <p class="modern-banner-subheadline translate-y-3 opacity-0 transition-all delay-300 ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                VexGenAI helps you generate marketing content, design visuals, and automate your workflow — all powered by the smartest AI models on the planet.
            </p>

            <!-- Call-to-Action Buttons -->
            <div class="modern-banner-buttons translate-y-3 opacity-0 transition-all delay-[450ms] group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                @if ($fSetting->hero_button_type == 1)
                    <a
                        href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : route('register') }}"
                        class="modern-banner-button-primary"
                    >
                        {!! __($fSetting->hero_button ?: 'Start for Free') !!}
                    </a>
                @else
                    <a
                        href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                        class="modern-banner-button-primary"
                        data-fslightbox="video-gallery"
                    >
                        {!! __($fSetting->hero_button ?: 'Watch Demo') !!}
                    </a>
                @endif
                <a
                    href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                    class="modern-banner-button-secondary"
                    @if ($fSetting->hero_button_type == 1) data-fslightbox="video-gallery" @endif
                >
                    {{ $fSetting->hero_button_type == 1 ? 'Watch Demo' : (__($fSetting->hero_button) ?: 'Start for Free') }}
                </a>
            </div>

            <!-- Trust Message -->
            <p class="modern-banner-trust translate-y-4 opacity-0 transition-all delay-[550ms] group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                {{ $fSetting->hero_trust_text ?? 'Trusted by 30,000+ creators worldwide.' }}
            </p>
        </div>

        <!-- Floating Information Box - Left -->
        

        <!-- Infinity Icon -->
        <div class="modern-banner-infinity translate-y-7 opacity-0 transition-all delay-[700ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18.178 8a10 10 0 0 0-12.356 0"/>
                <path d="M5.822 16a10 10 0 0 0 12.356 0"/>
            </svg>
        </div>
    </div>

    <!-- AI Model Logos Band -->
    <div class="modern-banner-logos-band">
        <div class="modern-banner-logos-scroll">
            <div class="modern-banner-logos-track">
                <!-- First set (purple) -->
                <span class="modern-banner-logo modern-banner-logo-primary">Grok</span>
                <span class="modern-banner-logo modern-banner-logo-primary">ChatGPT</span>
                <!-- Repeating set (grey) -->
                <span class="modern-banner-logo">deepseek</span>
                <span class="modern-banner-logo">Gemini</span>
                <span class="modern-banner-logo">Grok</span>
                <span class="modern-banner-logo">ChatGPT</span>
                <span class="modern-banner-logo">deepseek</span>
                <span class="modern-banner-logo">Gemini</span>
                <!-- Duplicate for seamless loop -->
                <span class="modern-banner-logo">Grok</span>
                <span class="modern-banner-logo">ChatGPT</span>
                <span class="modern-banner-logo">deepseek</span>
                <span class="modern-banner-logo">Gemini</span>
            </div>
        </div>
    </div>
</section>
