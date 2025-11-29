@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Affiliate'))
@section('titlebar_title')
    <span class="affiliate-page-title">
        {{ __('Affiliate') }}
    </span>
@endsection
@section('titlebar_actions')
    <x-button
        variant="primary"
        href="{{ route('dashboard.user.affiliates.users') }}"
    >
        {{ __('Affilated Users') }}
    </x-button>
@endsection

@push('css')
    <style>
        /* Affiliate Page Background - Matching Dashboard Theme */
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
        #rocket-stars-affiliate {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        
        /* Unique Heading Styling - Gradient Text with Glow */
        .affiliate-page-title {
            display: inline-block;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 40%, #7b2ff7 100%);
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
                        drop-shadow(0 0 20px rgba(0, 153, 255, 0.5));
            }
        }
        
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
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .affiliate-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .affiliate-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Card Body Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] .lqd-card [class*="body"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card-body {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
        }
        
        /* Card Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Override gradient background for affiliate overview card */
        body[data-theme="marketing-bot-dashboard"] .lqd-affiliate-overview {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
        }
        
        /* Form Input Styling */
        body[data-theme="marketing-bot-dashboard"] input,
        body[data-theme="marketing-bot-dashboard"] textarea,
        body[data-theme="marketing-bot-dashboard"] select {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] input::placeholder,
        body[data-theme="marketing-bot-dashboard"] textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] input:focus,
        body[data-theme="marketing-bot-dashboard"] textarea:focus,
        body[data-theme="marketing-bot-dashboard"] select:focus {
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Table Styling */
        body[data-theme="marketing-bot-dashboard"] table,
        body[data-theme="marketing-bot-dashboard"] .lqd-table {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
        }
        
        body[data-theme="marketing-bot-dashboard"] table thead,
        body[data-theme="marketing-bot-dashboard"] .lqd-table thead {
            background: rgba(10, 14, 39, 0.8) !important;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] table th,
        body[data-theme="marketing-bot-dashboard"] .lqd-table th {
            color: rgba(255, 255, 255, 0.9) !important;
            border-bottom: 1px solid rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] table tbody,
        body[data-theme="marketing-bot-dashboard"] .lqd-table tbody {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] table tr,
        body[data-theme="marketing-bot-dashboard"] .lqd-table tr {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease;
        }
        
        body[data-theme="marketing-bot-dashboard"] table tr:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-table tr:hover {
            background: rgba(0, 212, 255, 0.1) !important;
            transform: translateX(5px);
        }
        
        body[data-theme="marketing-bot-dashboard"] table td,
        body[data-theme="marketing-bot-dashboard"] .lqd-table td {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground,
        body[data-theme="marketing-bot-dashboard"] h2,
        body[data-theme="marketing-bot-dashboard"] h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .text-foreground,
        body[data-theme="marketing-bot-dashboard"] p,
        body[data-theme="marketing-bot-dashboard"] li {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Numbered list items */
        body[data-theme="marketing-bot-dashboard"] ol li span {
            background: rgba(0, 212, 255, 0.2) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(0, 212, 255, 0.9) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-affiliate"></div>
    
    <div class="pt-6 relative z-10">
        <div class="flex flex-wrap justify-between gap-y-8">
            <x-card
                class="lqd-affiliate-overview bg-gradient-to-b from-blue-400/30 to-transparent shadow-sm"
                size="lg"
            >
                <div class="flex flex-wrap gap-y-8">
                    <div class="w-full md:w-5/12">
                        <h4 class="mb-10 w-10/12 text-xl">
                            {{ __('Invite your friends and earn lifelong recurring commissions from every purchase they make') }}.🎁
                        </h4>
                        <p class="mb-2 text-2xs text-heading-foreground">
                            {{ __('Affiliate Link') }}
                        </p>

                        <div class="relative">
                            <x-forms.input
                                class="hidden"
                                id="ref-code"
                                disabled
                                value="{{ url('/') . '/register?aff=' . \Illuminate\Support\Facades\Auth::user()->affiliate_code }}"
                            />
                            <x-forms.input
                                class="h-10 bg-background"
                                disabled
                                value="{{ str()->limit(url('/') . '/register?aff=' . \Illuminate\Support\Facades\Auth::user()->affiliate_code, 60) }}"
                            />
                            <x-button
                                class="copy-aff-link absolute end-0 top-0 inline-flex h-full w-9 items-center rounded-input bg-transparent text-heading-foreground hover:bg-emerald-400 hover:text-white"
                                variant="link"
                                size="none"
                            >
                                <x-tabler-copy class="size-4" />
                            </x-button>
                        </div>
                    </div>

                    <div class="ms-auto w-full text-center font-semibold text-heading-foreground max-md:-order-1 max-md:mb-3 max-md:!text-start md:w-4/12">
                        <h4 class="mb-0 text-base">
                            {{ __('Earnings') }}
                        </h4>

                        <p class="mb-2 text-6xl">
                            @if (currencyShouldDisplayOnRight(currency()->symbol))
                                {{ $totalEarnings - $totalWithdrawal }}{{ currency()->symbol }}
                            @else
                                {{ currency()->symbol }}{{ max(0, $totalEarnings - $totalWithdrawal) }}
                            @endif
                        </p>

                        <p class="mb-0">
                            <span class="opacity-60">
                                {{ __('Commission Rate') }}:
                            </span>
                            {{ $setting->affiliate_commission_percentage }}%
                        </p>

                        <p class="mb-0">
                            <span class="opacity-60">
                                {{ __('Referral Program') }}:
                            </span>
                            @if ($is_onetime_commission)
                                {{ __('First Purchase') }}
                            @else
                                {{ __('All Purchases') }}
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>

            <x-card class="lqd-affiliate-form w-full lg:w-[48%]">
                <h2 class="mb-6">
                    {{ __('How it Works') }}
                </h2>

                <ol class="mb-12 flex flex-col gap-4 text-heading-foreground">
                    <li>
                        <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                            1
                        </span>
                        {!! __('You <strong>send your invitation link</strong> to your friends.') !!}
                    </li>
                    <li>
                        <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                            2
                        </span>
                        {!! __('<strong>They subscribe</strong> to a paid plan by using your refferral link.') !!}
                    </li>
                    <li>
                        <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                            3
                        </span>
                        @if ($is_onetime_commission)
                            {!! __('From their first purchase, you will begin <strong>earning one-time commissions</strong>.') !!}
                        @else
                            {!! __('From their first purchase, you will begin <strong>earning recurring commissions</strong>.') !!}
                        @endif
                    </li>
                </ol>

                <form
                    class="flex flex-col gap-3"
                    id="send_invitation_form"
                    onsubmit="return sendInvitationForm();"
                >
                    <x-forms.input
                        class:label="text-heading-foreground"
                        id="to_mail"
                        label="{{ __('Affiliate Link') }}"
                        size="sm"
                        type="email"
                        name="to_mail"
                        placeholder="{{ __('Email address') }}"
                        required
                    >
                        <x-slot:icon>
                            <x-tabler-mail class="absolute end-3 top-1/2 size-5 -translate-y-1/2" />
                        </x-slot:icon>
                    </x-forms.input>

                    <x-button
                        class="w-full"
                        id="send_invitation_button"
                        type="submit"
                        form="send_invitation_form"
                    >
                        {{ __('Send') }}
                    </x-button>
                </form>
            </x-card>

            <x-card class="lqd-affiliate-withdrawal w-full lg:w-[48%]">
                <h2 class="mb-6">
                    {{ __('Withdrawal Form') }}
                </h2>

                <form
                    class="flex flex-col gap-5"
                    id="send_request_form"
                    onsubmit="return sendRequestForm();"
                >
                    <x-forms.input
                        id="affiliate_bank_account"
                        label="{{ __('Your Bank Information') }}"
                        type="textarea"
                        rows="2"
                        name="affiliate_bank_account"
                        placeholder="{{ __('Bank of America - 2382372329 3843749 2372379') }}"
                    >{{ Auth::user()->affiliate_bank_account ?? null }}</x-forms.input>

                    <x-forms.input
                        id="amount"
                        label="{{ __('Amount') }}"
                        type="number"
                        name="amount"
                        min="{{ $setting->affiliate_minimum_withdrawal }}"
                        placeholder="{{ __('Minimum Withdrawal Amount is') }} {{ $setting->affiliate_minimum_withdrawal }}"
                    />

                    <x-button
                        class="w-full"
                        id="send_request_button"
                        type="submit"
                    >
                        {{ __('Send Request') }}
                    </x-button>
                </form>
            </x-card>

            <h2 class="-mb-2 w-full">
                {{ __('Withdrawal Requests') }}
            </h2>

            <x-table class="lqd-affiliate-withdrawals-table">
                <x-slot:head>
                    <tr>
                        <th>
                            {{ __('No') }}
                        </th>
                        <th>
                            {{ __('Amount') }}
                        </th>
                        <th>
                            {{ __('Status') }}
                        </th>
                        <th>
                            {{ __('Date') }}
                        </th>
                    </tr>
                </x-slot:head>
                <x-slot:body
                    class="font-medium"
                >
                    @forelse ($list2 as $entry)
                        <tr>
                            <td>
                                AFF-WTHDRWL-{{ $entry->id }}
                            </td>
                            <td>
                                {{ $entry->amount }}
                            </td>
                            <td>
                                {{ $entry->status }}
                            </td>
                            <td>
                                {{ $entry->created_at }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="text-center"
                                colspan="4"
                            >
                                {{ __('You have no withdrawal request') }}
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Affiliate Page
        let affiliateStars = [];
        let affiliateMouseX = 0;
        let affiliateMouseY = 0;
        
        function createAffiliateStars() {
            const starsContainer = document.getElementById('rocket-stars-affiliate');
            if (!starsContainer) return;
            
            const starCount = 100;
            affiliateStars = [];
            
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
                affiliateStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-affiliate');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                affiliateMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                affiliateMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateAffiliateStars();
            });
            
            // Initialize stars
            updateAffiliateStars();
        }
        
        function updateAffiliateStars() {
            affiliateStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = affiliateMouseX - starX;
                const dy = affiliateMouseY - starY;
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
            createAffiliateStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createAffiliateStars);
        } else {
            createAffiliateStars();
        }
    </script>
    
    <script src="{{ custom_theme_url('/assets/js/panel/affiliate.js') }}"></script>
@endpush
