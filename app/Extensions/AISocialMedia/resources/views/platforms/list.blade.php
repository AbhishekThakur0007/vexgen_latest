@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Connect Your Accounts'))
@section('titlebar_title')
    <span class="platform-list-page-title">
        {{ __('Connect Your Accounts') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('Connect your social media accounts to schedule posts') }}
@endsection
@section('titlebar_actions', '')

@push('css')
    <style>
        /* Platform List Page Background - Matching Chatbot Theme */
        body[data-theme="marketing-bot-dashboard"] .lqd-page-wrapper,
        body[data-theme="marketing-bot-dashboard"] {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1d3a 50%, #0f1729 100%) !important;
            min-height: 100vh;
        }
        
        /* Ensure content appears above stars */
        .lqd-page-wrapper > .lqd-page-container,
        .lqd-page-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Stars background positioning */
        #rocket-stars-platform-list {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        /* Animated stars */
        @keyframes twinkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Page Title Styling - Matching Chatbot Theme */
        .platform-list-page-title {
            display: inline-block;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 50%, #00ff88 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease-in-out infinite, text-glow-pulse 3s ease-in-out infinite;
            position: relative;
            text-shadow: 0 0 40px rgba(0, 212, 255, 0.5);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes text-glow-pulse {
            0%, 100% {
                filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6)) 
                        drop-shadow(0 0 30px rgba(123, 47, 247, 0.4));
            }
            50% {
                filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.9)) 
                        drop-shadow(0 0 40px rgba(123, 47, 247, 0.6))
                        drop-shadow(0 0 20px rgba(0, 255, 136, 0.5));
            }
        }

        /* Improved Font Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-page-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }

        /* Better Typography for Headings */
        body[data-theme="marketing-bot-dashboard"] .lqd-titlebar-title {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        /* Responsive Title */
        @media (max-width: 768px) {
            .platform-list-page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .platform-list-page-title {
                font-size: 1.75rem;
            }
        }

        /* Platform Cards Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }

        /* Card Rotating Background Effect */
        body[data-theme="marketing-bot-dashboard"] .lqd-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover::before {
            opacity: 1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Platform Card Headings */
        body[data-theme="marketing-bot-dashboard"] .lqd-card h2 {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }

        /* Platform Icons - Modern Styling */
        .platform-icon-modern {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%);
            border: 2px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3), inset 0 0 10px rgba(123, 47, 247, 0.2);
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover .platform-icon-modern {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.5), inset 0 0 15px rgba(123, 47, 247, 0.3);
        }

        /* Buttons Modern Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-btn,
        body[data-theme="marketing-bot-dashboard"] .lqd-card button {
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-btn:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        /* Disconnect Button */
        .disconnect-button-modern {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.2)) !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: rgba(239, 68, 68, 0.9) !important;
            transition: all 0.3s ease;
        }

        .disconnect-button-modern:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(220, 38, 38, 0.3)) !important;
            border-color: rgba(239, 68, 68, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .disconnect-button-modern svg,
        .update-button-modern svg,
        .connect-button-modern svg {
            filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.6));
            transition: all 0.3s ease;
        }

        .disconnect-button-modern:hover svg {
            filter: drop-shadow(0 0 12px rgba(239, 68, 68, 0.9));
            transform: scale(1.1);
        }

        .update-button-modern:hover svg,
        .connect-button-modern:hover svg {
            filter: drop-shadow(0 0 12px rgba(0, 212, 255, 0.9));
            transform: scale(1.1);
        }

        /* Update/Connect Buttons */
        .update-button-modern,
        .connect-button-modern {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        .update-button-modern:hover,
        .connect-button-modern:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card input,
        body[data-theme="marketing-bot-dashboard"] .lqd-card select,
        body[data-theme="marketing-bot-dashboard"] .lqd-card textarea {
            background: rgba(10, 14, 39, 0.5) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-card select:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-card textarea:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card label {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Links Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card a {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card a:hover {
            color: rgba(0, 212, 255, 1) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* HR Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card hr {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }

        /* Alert Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-alert {
            background: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-alert a {
            color: rgba(239, 68, 68, 0.9) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-platform-list"></div>
    
    <div class="py-10 relative z-10">

        <div class="flex flex-wrap justify-between gap-y-8">
            <x-card class="w-full lg:w-[48%]">
                <h2 class="mb-7 flex flex-wrap items-center justify-between gap-3">
                    <span class="flex items-center gap-3">
                        <span class="platform-icon-modern">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.6));">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </span>
                        {{ __('Twitter/X') }}
                    </span>
                    @if ($platformX)
                        <x-button
                            class="ms-auto disconnect-button-modern"
                            variant="secondary"
                            href="{{ route('dashboard.user.automation.platform.disconnect', $platformX->id) }}"
                        >
                            <x-tabler-unlink class="size-4 me-2" />
                            {{ __('Disconnect') }}
                        </x-button>
                    @endif
                </h2>

                <form
                    class="flex flex-col gap-6"
					method="post"
					action="{{ route('dashboard.user.automation.platform.update', \App\Extensions\AISocialMedia\System\Enums\Platform::x->value) }}"
                >
					@csrf
                    <a
                        class="underline"
                        href="https://developer.x.com/en/docs/apps/overview"
                        target="_blank"
                    >
                        {{ __('X Developer Portal') }}</a>
                    <x-forms.input
                        id="consumer_key"
                        label="{{ __('API Key') }}"
                        name="consumer_key"
                        size="lg"
                        required
                        value="{{ $platformX?->getCredentialValue('consumer_key')}}"
                    />

                    <x-forms.input
                        id="consumer_secret"
                        label="{{ __('API Key Secret') }}"
                        name="consumer_secret"
                        size="lg"
                        required
                        value="{{  $platformX?->getCredentialValue('consumer_secret') }}"
                    />

                    <x-forms.input
                        id="bearer_token"
                        label="{{ __('Bearer Token') }}"
                        name="bearer_token"
                        size="lg"
                        required
						value="{{  $platformX?->getCredentialValue('bearer_token') }}"
                    />

                    <x-forms.input
                        id="access_token"
                        label="{{ __('Access Token') }}"
                        name="access_token"
                        size="lg"
                        required
						value="{{  $platformX?->getCredentialValue('access_token') }}"
                    />

                    <x-forms.input
                        id="access_token_secret"
                        label="{{ __('Access Token Secret') }}"
                        name="access_token_secret"
                        size="lg"
                        required
						value="{{  $platformX?->getCredentialValue('access_token_secret') }}"
                    />

                    <x-forms.input
                        id="account_id"
                        label="{{ __('Client ID') }}"
                        name="account_id"
                        size="lg"
                        required
						value="{{  $platformX?->getCredentialValue('account_id') }}"
                    />


					@if($platformX)
						<hr>
						<x-forms.input
							disabled
							label="{{ __('Expired At') }}"
							name="expires_at"
							size="lg"
							required
							value="{{  $platformX?->getAttribute('expires_at') }}"
						/>
					@endif

                    <x-button
                        id="twitter_button"
                        type="submit"
                        size="lg"
                        class="update-button-modern"
                    >
                        <x-tabler-device-floppy class="size-4 me-2" />
                        {{ __('Update') }}
                    </x-button>
                </form>
            </x-card>

            <x-card class="w-full lg:w-[48%]">
                <h2 class="mb-7 flex flex-wrap items-center justify-between gap-3">
                    <span class="flex items-center gap-3">
                        <span class="platform-icon-modern">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="filter: drop-shadow(0 0 8px rgba(0, 119, 181, 0.6));">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </span>
                        {{ __('LinkedIn') }}
                    </span>
                    @if ($platformLinkedin)
                        <x-button
                            class="ms-auto disconnect-button-modern"
                            variant="secondary"
                            href="{{ route('dashboard.user.automation.platform.disconnect', $platformLinkedin->id) }}"
                        >
                            <x-tabler-unlink class="size-4 me-2" />
                            {{ __('Disconnect') }}
                        </x-button>
                    @endif
                </h2>

				<form
					class="flex flex-col gap-6"
					method="post"
					action="{{ route('dashboard.user.automation.platform.update', \App\Extensions\AISocialMedia\System\Enums\Platform::linkedin->value) }}"
				>
					@csrf
                    <a
                        class="underline"
                        href="https://www.linkedin.com/developers/tools/oauth"
                        target="_blank"
                    >
                        {{ __('OAuth token generator tool') }}</a>
                    <x-forms.input
                        id="access_token"
                        label="{{ __('Your Access Token') }}"
                        name="access_token"
                        size="lg"
                        required
                        value="{{ $platformLinkedin?->getCredentialValue('access_token') }}"
                    />

					@if($platformLinkedin)
						<hr>
						<x-forms.input
							disabled
							label="{{ __('Expired At') }}"
							name="expires_at"
							size="lg"
							required
							value="{{  $platformLinkedin?->getAttribute('expires_at') }}"
						/>
					@endif

                    <x-button
                        id="linkedin_button"
                        size="lg"
                        type="submit"
                        class="update-button-modern"
                    >
                        <x-tabler-device-floppy class="size-4 me-2" />
                        {{ __('Update') }}
                    </x-button>
                </form>
            </x-card>

            <x-card class="w-full lg:w-[48%]">
                <h2 class="mb-7 flex flex-wrap items-center justify-between gap-3">
                    <span class="flex items-center gap-3">
                        <span class="platform-icon-modern">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="filter: drop-shadow(0 0 8px rgba(225, 48, 108, 0.6));">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </span>
                        {{ __('Instagram') }}
                    </span>
                    @if ($platformInstagram)
                        <x-button
                            class="ms-auto disconnect-button-modern"
                            variant="secondary"
                            href="{{ route('dashboard.user.automation.platform.disconnect', $platformInstagram->id) }}"
                        >
                            <x-tabler-unlink class="size-4 me-2" />
                            {{ __('Disconnect') }}
                        </x-button>
					@else
						<x-button
							target="_blank"
							class="ms-auto connect-button-modern"
							variant="success"
							href="{{ url('oauth/redirect/instagram') }}"
						>
							<x-tabler-link class="size-4 me-2" />
							{{ __('Connect to instagram') }}
						</x-button>
					@endif
                </h2>

				<form
					class="flex flex-col gap-6"
				>
					@csrf
                    <x-forms.input
						disabled
                        label="{{ __('Name') }}"
                        size="lg"
                        required
                        value="{{ $platformInstagram?->getCredentialValue('name') }}"
                    />
                    <x-forms.input
						disabled
                        label="{{ __('Username') }}"
                        size="lg"
                        required
                        value="{{ $platformInstagram?->getCredentialValue('username') }}"
                    />


					@if($platformInstagram)
						<hr>
						<x-forms.input
							disabled
							label="{{ __('Expired At') }}"
							name="expires_at"
							size="lg"
							required
							value="{{  $platformInstagram?->getAttribute('expires_at') }}"
						/>
					@endif
					@if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
						<x-alert class="mt-2 mb-3">
							<p>
								{!! trans('To run Instagram, first adjust the settings. You can adjust the settings from <a class="text-red-600" href="/dashboard/admin/automation/settings">here</a>.') !!}
							</p>
						</x-alert>
					@endif
                </form>
            </x-card>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Platform List Page
        let platformListStars = [];
        let platformListMouseX = 0;
        let platformListMouseY = 0;
        
        function createPlatformListStars() {
            const starsContainer = document.getElementById('rocket-stars-platform-list');
            if (!starsContainer) return;
            
            const starCount = 100;
            platformListStars = [];
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'rocket-star interactive-dashboard-star';
                const size = Math.random() * 2 + 1;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 3;
                
                star.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: white;
                    border-radius: 50%;
                    left: ${x}%;
                    top: ${y}%;
                    opacity: ${Math.random() * 0.5 + 0.3};
                    box-shadow: 0 0 ${size * 2}px rgba(0, 212, 255, 0.6),
                                0 0 ${size * 4}px rgba(123, 47, 247, 0.4);
                    animation: twinkle ${duration}s ease-in-out infinite;
                    animation-delay: ${delay}s;
                    transition: all 0.3s ease;
                    pointer-events: none;
                `;
                
                star.dataset.x = x;
                star.dataset.y = y;
                star.dataset.baseOpacity = star.style.opacity;
                star.dataset.baseSize = size;
                
                starsContainer.appendChild(star);
                platformListStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-platform-list');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                platformListMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                platformListMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updatePlatformListStars();
            });
            
            // Initialize stars
            updatePlatformListStars();
        }
        
        function updatePlatformListStars() {
            platformListStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = platformListMouseX - starX;
                const dy = platformListMouseY - starY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                // Calculate intensity based on distance (closer = brighter)
                const maxDistance = 30;
                const intensity = Math.max(0, 1 - (distance / maxDistance));
                
                // Update star properties
                const baseOpacity = parseFloat(star.dataset.baseOpacity);
                const baseSize = parseFloat(star.dataset.baseSize);
                
                const newOpacity = Math.min(1, baseOpacity + intensity * 0.7);
                const newSize = baseSize + intensity * 2;
                const glowSize = newSize * 3;
                
                star.style.opacity = newOpacity;
                star.style.width = newSize + 'px';
                star.style.height = newSize + 'px';
                star.style.boxShadow = `
                    0 0 ${glowSize}px rgba(0, 212, 255, ${0.6 + intensity * 0.4}),
                    0 0 ${glowSize * 2}px rgba(123, 47, 247, ${0.4 + intensity * 0.3}),
                    0 0 ${glowSize * 3}px rgba(0, 255, 136, ${intensity * 0.2})
                `;
            });
        }
        
        // Initialize stars when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createPlatformListStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createPlatformListStars);
        } else {
            createPlatformListStars();
        }
    </script>
@endpush
