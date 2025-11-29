@php
    $team = Auth::user()->getAttribute('team');
    $teamManager = Auth::user()->getAttribute('teamManager');

    $titlebar_links = [];
    $filters = [];
    if ($plansSubscriptionMonthly->count() > 0) {
        $titlebar_links[] = [
            'label' => 'Monthly',
            'link' => '#monthly',
        ];
        $filters[] = 'Monthly';
    }
    if ($plansSubscriptionAnnual->count() > 0) {
        $titlebar_links[] = [
            'label' => 'Yearly',
            'link' => '#yearly',
        ];
        $filters[] = 'Yearly';
    }
    if ($prepaidplans->count() > 0) {
        $titlebar_links[] = [
            'label' => 'Pre-Paid',
            'link' => '#pre-paid',
        ];
        $filters[] = 'Pre-Paid';
    }
    if ($plansSubscriptionLifetime->count() > 0) {
        $titlebar_links[] = [
            'label' => 'Lifetime',
            'link' => '#lifetime',
        ];
        $filters[] = 'Lifetime';
    }
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Plans and Pricing'))

@section('titlebar_title')
    <span class="subscription-title">
        {{ __('Plans & Pricing') }}
    </span>
@endsection

@section('titlebar_subtitle')
    {{ __('Fuel your creative workflows with the perfect mix of credits, seats, and automation features.') }}
@endsection

@section('titlebar_actions')
    <div class="flex flex-wrap gap-3">
        <x-button
            class="subscription-titlebar-btn"
            href="{{ route('dashboard.user.orders.index') }}"
            variant="ghost-shadow"
        >
            <x-tabler-file-invoice class="size-4" />
            {{ __('Billing History') }}
        </x-button>
        <x-button
            class="subscription-titlebar-btn"
            href="#overview"
            variant="secondary"
        >
            <x-tabler-sparkles class="size-4" />
            {{ __('Current Overview') }}
        </x-button>
    </div>
@endsection

@inject('paymentControls', 'App\Http\Controllers\Finance\PaymentProcessController')
@inject('gatewayControls', 'App\Http\Controllers\Finance\GatewayController')

@push('css')
    <style>
        #subscriptionPlansPage {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding-bottom: 4rem;
        }

        #subscriptionPlansPage .subscription-plans-aurora {
            position: absolute;
            inset: 0 0 auto 0;
            height: 480px;
            background: radial-gradient(circle at 20% 20%, rgba(131, 56, 236, 0.35), transparent 45%),
                        radial-gradient(circle at 80% 0%, rgba(0, 224, 255, 0.25), transparent 40%),
                        radial-gradient(circle at 50% 100%, rgba(111, 72, 236, 0.35), transparent 55%);
            filter: blur(40px);
            opacity: 0.7;
            z-index: 0;
            animation: subscriptionAurora 18s ease-in-out infinite alternate;
        }

        #subscriptionPlansPage .subscription-plans-stars {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        #subscriptionPlansPage .subscription-plans-stars span {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.65);
            border-radius: 999px;
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.8);
            animation: subscriptionTwinkle 6s linear infinite;
        }

        #subscriptionPlansPage .subscription-plans-stars span:nth-child(1) { top: 12%; left: 8%; animation-delay: 0s; }
        #subscriptionPlansPage .subscription-plans-stars span:nth-child(2) { top: 5%; left: 65%; animation-delay: 1s; }
        #subscriptionPlansPage .subscription-plans-stars span:nth-child(3) { top: 30%; left: 85%; animation-delay: 2.4s; }
        #subscriptionPlansPage .subscription-plans-stars span:nth-child(4) { top: 48%; left: 25%; animation-delay: 3.2s; }
        #subscriptionPlansPage .subscription-plans-stars span:nth-child(5) { top: 70%; left: 12%; animation-delay: 4s; }
        #subscriptionPlansPage .subscription-plans-stars span:nth-child(6) { top: 82%; left: 78%; animation-delay: 5s; }

        .subscription-content {
            position: relative;
            z-index: 1;
        }

        .subscription-title {
            align-items: center;
            gap: 0.5rem;
            font-size: clamp(2rem, 3vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(120deg, #00e0ff 0%, #7c3aed 50%, #ff47a3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 220% auto;
            animation: subscriptionGradient 6s ease-in-out infinite;
        }

        .subscription-titlebar-btn {
            border-radius: 999px;
        }

        .lqd-plan-overview {
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.9) 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            overflow: hidden;
        }

        .lqd-plan-overview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent 0%,
                rgba(124, 58, 237, 0.6) 25%,
                rgba(0, 224, 255, 0.6) 50%,
                rgba(124, 58, 237, 0.6) 75%,
                transparent 100%);
            animation: shimmer 3s ease-in-out infinite;
        }

        .lqd-plan-overview::after {
            content: '';
            position: absolute;
            inset: -50% -30%;
            background: radial-gradient(circle at 50% 50%, 
                rgba(124, 58, 237, 0.15) 0%,
                transparent 70%);
            filter: blur(80px);
            opacity: 0.6;
            pointer-events: none;
            z-index: 0;
        }

        .lqd-plan-overview > * {
            position: relative;
            z-index: 1;
        }

        .plan-summary-grid {
            position: relative;
            z-index: 1;
        }

        .plan-summary-grid::after {
            content: '';
            position: absolute;
            inset: -30% -10% auto;
            height: 200px;
            background: linear-gradient(120deg, rgba(124, 58, 237, 0.2), rgba(45, 212, 191, 0.2));
            filter: blur(60px);
            opacity: 0.8;
            pointer-events: none;
            z-index: -1;
        }

        .plan-summary-card {
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: linear-gradient(135deg, 
                rgba(7, 11, 30, 0.85) 0%,
                rgba(15, 23, 42, 0.75) 100%);
            backdrop-filter: blur(16px);
            border-radius: 1.25rem;
            transition: all 280ms cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .plan-summary-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, 
                rgba(124, 58, 237, 0.3),
                rgba(0, 224, 255, 0.3),
                rgba(124, 58, 237, 0.3));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 280ms ease;
        }

        .plan-summary-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, 
                rgba(124, 58, 237, 0.1) 0%,
                transparent 70%);
            opacity: 0;
            transition: opacity 280ms ease;
            pointer-events: none;
        }

        .plan-summary-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: rgba(124, 58, 237, 0.5);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.4),
                        0 0 0 1px rgba(124, 58, 237, 0.2),
                        0 0 60px rgba(124, 58, 237, 0.15);
        }

        .plan-summary-card:hover::before {
            opacity: 1;
        }

        .plan-summary-card:hover::after {
            opacity: 1;
        }

        .plan-summary-card svg {
            filter: drop-shadow(0 0 8px rgba(124, 58, 237, 0.4));
            transition: filter 280ms ease;
        }

        .plan-summary-card:hover svg {
            filter: drop-shadow(0 0 12px rgba(124, 58, 237, 0.6));
        }

        .plan-summary-card .font-semibold {
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .lqd-plan-overview h3 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.85) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.01em;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .subscription-section-heading {
            font-weight: 700;
            font-size: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .subscription-section-heading::after {
            content: '';
            display: inline-block;
            width: 65px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, #4ade80, #60a5fa, #c084fc);
        }

        .subscription-section-lede {
            max-width: 640px;
        }

        .subscription-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .subscription-pill-row span {
            font-size: 0.85rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .subscription-plans-filters {
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.25);
        }

        .subscription-plans-filters button {
            color: inherit;
            font-weight: 600;
        }

        .subscription-plan-grid {
            position: relative;
        }

        .subscription-plan-card {
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(11, 16, 40, 0.9);
            backdrop-filter: blur(14px);
            transition: transform 250ms ease, border-color 250ms ease, box-shadow 250ms ease;
        }

        .subscription-plan-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            pointer-events: none;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0.08), transparent);
            transition: opacity 250ms ease;
        }

        .subscription-plan-card:hover {
            transform: translateY(-6px);
            border-color: rgba(104, 74, 226, 0.45);
            box-shadow: 0 35px 55px rgba(15, 23, 42, 0.35);
        }

        .subscription-plan-card:hover::before {
            opacity: 1;
        }

        .subscription-plan-card--featured {
            border-color: rgba(123, 63, 238, 0.65);
            box-shadow: 0 18px 55px rgba(99, 102, 241, 0.35);
        }

        .subscription-plan-card--featured::after {
            content: '✨';
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 1.25rem;
        }

        .subscription-plan-card .text-[50px] {
            display: flex;
            align-items: flex-end;
            gap: 0.75rem;
        }

        .subscription-plan-card .text-[50px] .inline-flex div,
        .subscription-plan-card .text-[50px] .inline-flex span {
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .subscription-plan-card .text-sm {
            letter-spacing: 0.01em;
        }

        .subscription-plan-card .text-green-500,
        .subscription-plan-card .text-foreground\/60 {
            font-size: 0.95rem;
        }

        .subscription-plan-card .w-full .flex {
            align-items: center;
        }

        .subscription-plan-card .flex.flex-col.gap-4 .w-full {
            border-radius: 1.5rem;
        }

        @keyframes subscriptionGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes subscriptionAurora {
            0% { transform: translateY(-20px); opacity: 0.55; }
            50% { transform: translateY(10px); opacity: 0.85; }
            100% { transform: translateY(-15px); opacity: 0.6; }
        }

        @keyframes subscriptionTwinkle {
            0% { opacity: 0.2; transform: scale(0.8); }
            50% { opacity: 0.9; transform: scale(1.2); }
            100% { opacity: 0.2; transform: scale(0.85); }
        }

        @media (max-width: 768px) {
            .subscription-titlebar-btn {
                width: 100%;
                justify-content: center;
            }

            .subscription-plan-card {
                border-radius: 1.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div
        id="subscriptionPlansPage"
        class="subscription-plans-wrapper"
    >
        <div
            aria-hidden="true"
            class="subscription-plans-aurora"
        ></div>
        <div
            aria-hidden="true"
            class="subscription-plans-stars"
        >
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="subscription-content py-10">
        <div class="flex flex-col gap-14">
            <div class="w-full">
                <x-card
                    class="lqd-plan-overview scroll-mt-11 pb-4 pt-2 max-md:text-center"
                    id="overview"
                    size="lg"
                >
                    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                        <h3 class="mb-0">
                            @lang('Here is your plan summary:')
                        </h3>
                        <div class="flex items-center gap-2">
                            @if ($getCurrentActiveSubscription = \App\Helpers\Classes\Helper::getCurrentActiveSubscription())
                                <x-button
                                    class="hover:text-red-500"
                                    variant="link"
                                    onclick="return confirm('Are you sure to cancel your plan? You will lose your remaining usage.');"
                                    href="{{ route('dashboard.user.payment.cancelActiveSubscription') }}"
                                >
                                    {{ __('Cancel My Plan') }}
                                </x-button>
                            @endif
                            <x-button
                                variant="ghost-shadow"
                                href="{{ route('dashboard.user.payment.subscription') }}"
                            >
                                <x-tabler-plus class="size-4" />
                                {{ __('Upgrade Your plan') }}
                            </x-button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 plan-summary-grid">
                        <x-card
                            class="plan-summary-card flex items-center text-start text-2xs hover:-translate-y-1 hover:shadow-lg hover:shadow-black/5"
                            variant="shadow"
                            size="sm"
                        >
                            <div class="flex items-center justify-between gap-1.5">
                                <p class="m-0">
                                    <span class="block font-semibold">
                                        @lang('Active Plan')
                                    </span>
                                    @if (Auth::user()->activePlan() != null)
                                        {{ getSubscriptionName() }}
                                    @else
                                        @lang('None')
                                    @endif
                                </p>
                                {{-- blade-formatter-disable --}}
                                <svg class="shrink-0" width="40" height="20" viewBox="0 0 40 20" fill="none" xmlns="http://www.w3.org/2000/svg" > <path d="M10.8346 9.99992L20.0013 19.1666L38.3346 0.833252M1.66797 9.99992L10.8346 19.1666M20.0013 9.99992L29.168 0.833252" stroke="url(#paint0_linear_210_8)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /> <defs> <linearGradient id="paint0_linear_210_8" x1="1.66797" y1="4.57325" x2="14.9702" y2="28.0385" gradientUnits="userSpaceOnUse" > <stop offset="0.139297" stop-color="#82E2F4" /> <stop offset="0.620738" stop-color="#8A8AED" /> <stop offset="1" stop-color="#6977DE" /> </linearGradient> </defs> </svg>
                                {{-- blade-formatter-enable --}}
                            </div>
                        </x-card>

                        <x-card
                            class="plan-summary-card flex items-center text-start text-2xs hover:-translate-y-1 hover:shadow-lg hover:shadow-black/5"
                            variant="shadow"
                            size="sm"
                        >
                            <div class="flex items-center justify-between gap-1.5">
                                <p class="m-0">
                                    <span class="block font-semibold">
                                        @lang('Renewal Date')
                                    </span>
                                    @if (Auth::user()->activePlan() != null)
                                        {{ getSubscriptionDaysLeft() }} @lang('Days')
                                    @else
                                        @lang('None')
                                    @endif
                                </p>
                                {{-- blade-formatter-disable --}}
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7.33203 12.8334C7.33203 11.861 7.71834 10.9283 8.40597 10.2407C9.09361 9.55306 10.0262 9.16675 10.9987 9.16675H32.9987C33.9712 9.16675 34.9038 9.55306 35.5914 10.2407C36.2791 10.9283 36.6654 11.861 36.6654 12.8334V34.8334C36.6654 35.8059 36.2791 36.7385 35.5914 37.4261C34.9038 38.1138 33.9712 38.5001 32.9987 38.5001H10.9987C10.0262 38.5001 9.09361 38.1138 8.40597 37.4261C7.71834 36.7385 7.33203 35.8059 7.33203 34.8334V12.8334Z" stroke="url(#paint0_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M29.332 5.5V12.8333" stroke="url(#paint1_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14.668 5.5V12.8333" stroke="url(#paint2_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M7.33203 20.1667H36.6654" stroke="url(#paint3_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.832 25.6667H12.8559" stroke="url(#paint4_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M18.3516 25.6667H18.3607" stroke="url(#paint5_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M23.8516 25.6667H23.8607" stroke="url(#paint6_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M29.3594 25.6667H29.3685" stroke="url(#paint7_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M23.8594 31.1667H23.8685" stroke="url(#paint8_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.8516 31.1667H12.8607" stroke="url(#paint9_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M18.3516 31.1667H18.3607" stroke="url(#paint10_linear_210_9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <defs> <linearGradient id="paint0_linear_210_9" x1="7.33203" y1="15.1507" x2="31.9427" y2="36.8574" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint1_linear_210_9" x1="29.332" y1="6.996" x2="30.8024" y2="7.17285" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint2_linear_210_9" x1="14.668" y1="6.996" x2="16.1384" y2="7.17285" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint3_linear_210_9" x1="7.33203" y1="20.3707" x2="7.3973" y2="22.0595" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint4_linear_210_9" x1="12.832" y1="25.8707" x2="12.8676" y2="25.8715" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint5_linear_210_9" x1="18.3516" y1="25.8707" x2="18.3652" y2="25.8709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint6_linear_210_9" x1="23.8516" y1="25.8707" x2="23.8652" y2="25.8709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint7_linear_210_9" x1="29.3594" y1="25.8707" x2="29.3731" y2="25.8709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint8_linear_210_9" x1="23.8594" y1="31.3707" x2="23.873" y2="31.3709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint9_linear_210_9" x1="12.8516" y1="31.3707" x2="12.8652" y2="31.3709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint10_linear_210_9" x1="18.3516" y1="31.3707" x2="18.3652" y2="31.3709" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> </defs> </svg>
                                {{-- blade-formatter-enable --}}
                            </div>
                        </x-card>

                        <x-card
                            class="plan-summary-card flex items-center text-start text-2xs hover:-translate-y-1 hover:shadow-lg hover:shadow-black/5"
                            variant="shadow"
                            size="sm"
                        >
                            <div class="flex items-center justify-between gap-1.5">
                                <p class="m-0">
                                    <span class="block font-semibold">
                                        @lang('Team Plan')
                                    </span>
                                    @if ($team && $team?->allow_seats > 0)
                                        @lang('Active')
                                    @else
                                        @lang('Not Active')
                                    @endif
                                </p>
                                {{-- blade-formatter-disable --}}
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_6425_3048)"> <path d="M5.5 22C5.5 24.1668 5.92678 26.3124 6.75599 28.3143C7.58519 30.3161 8.80057 32.1351 10.3327 33.6673C11.8649 35.1994 13.6839 36.4148 15.6857 37.244C17.6876 38.0732 19.8332 38.5 22 38.5C24.1668 38.5 26.3124 38.0732 28.3143 37.244C30.3161 36.4148 32.1351 35.1994 33.6673 33.6673C35.1994 32.1351 36.4148 30.3161 37.244 28.3143C38.0732 26.3124 38.5 24.1668 38.5 22C38.5 19.8332 38.0732 17.6876 37.244 15.6857C36.4148 13.6839 35.1994 11.8649 33.6673 10.3327C32.1351 8.80057 30.3161 7.58519 28.3143 6.75599C26.3124 5.92679 24.1668 5.5 22 5.5C19.8332 5.5 17.6876 5.92679 15.6857 6.75599C13.6839 7.58519 11.8649 8.80057 10.3327 10.3327C8.80057 11.8649 7.58519 13.6839 6.75599 15.6857C5.92678 17.6876 5.5 19.8332 5.5 22Z" stroke="url(#paint0_linear_6425_3048)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M16.5 18.3333C16.5 19.792 17.0795 21.191 18.1109 22.2224C19.1424 23.2539 20.5413 23.8333 22 23.8333C23.4587 23.8333 24.8576 23.2539 25.8891 22.2224C26.9205 21.191 27.5 19.792 27.5 18.3333C27.5 16.8746 26.9205 15.4757 25.8891 14.4442C24.8576 13.4128 23.4587 12.8333 22 12.8333C20.5413 12.8333 19.1424 13.4128 18.1109 14.4442C17.0795 15.4757 16.5 16.8746 16.5 18.3333Z" stroke="url(#paint1_linear_6425_3048)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M11.3086 34.5565C11.7624 33.0462 12.6909 31.7225 13.9564 30.7816C15.2219 29.8407 16.757 29.3329 18.3339 29.3333H25.6673C27.2462 29.3328 28.7832 29.8419 30.0496 30.7849C31.3161 31.728 32.2443 33.0546 32.6963 34.5675" stroke="url(#paint2_linear_6425_3048)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g> <defs> <linearGradient id="paint0_linear_6425_3048" x1="5.5" y1="12.232" x2="33.187" y2="36.652" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint1_linear_6425_3048" x1="16.5" y1="15.0773" x2="25.729" y2="23.2173" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <linearGradient id="paint2_linear_6425_3048" x1="11.3086" y1="30.4011" x2="13.5892" y2="38.6205" gradientUnits="userSpaceOnUse"> <stop stop-color="#82E2F4"/> <stop offset="0.502" stop-color="#8A8AED"/> <stop offset="1" stop-color="#6977DE"/> </linearGradient> <clipPath id="clip0_6425_3048"> <rect width="44" height="44" fill="white"/> </clipPath> </defs> </svg>
                                {{-- blade-formatter-enable --}}
                            </div>
                        </x-card>

                        <x-card
                            class="plan-summary-card flex items-center text-start text-2xs hover:-translate-y-1 hover:shadow-lg hover:shadow-black/5"
                            variant="shadow"
                            size="sm"
                        >
                            <x-credit-list />
                        </x-card>
                    </div>
                </x-card>
            </div>

            <div class="w-full">
                <h2 class="subscription-section-heading mb-5">
                    {{ __('Select a Plan') }}:
                </h2>
                <p class="subscription-section-lede mb-5">
                    @lang('Please select a subscription plan or a token pack to upgrade your current plan.')
                </p>
                <div class="subscription-pill-row">
                    <span>{{ __('Collaborative seats ready for teams') }}</span>
                    <span>{{ __('Usage caps reset with every cycle') }}</span>
                    <span>{{ __('Cancel or upgrade any time') }}</span>
                </div>

                <div class="flex justify-center">
                    <ul class="subscription-plans-filters mb-8 inline-flex justify-between gap-3 rounded-full bg-foreground/10 p-1 text-xs font-medium">
                        @foreach ($filters as $filter)
                            <li>
                                <button
                                    @class([
                                        'px-6 py-3 lg:min-w-40 leading-tight rounded-full transition-all hover:bg-background/80 [&.lqd-is-active]:bg-background [&.lqd-is-active]:shadow-[0_2px_12px_hsl(0_0%_0%/10%)]',
                                        'lqd-is-active' => $loop->first,
                                    ])
                                    x-data="{}"
                                    type="button"
                                    @click.prevent="$store.plansFilter.toggle('{{ $filter }}')"
                                    :class="{ 'lqd-is-active': $store.plansFilter.isActive('{{ $filter }}') }"
                                >
                                    @lang($filter)

                                    @if ($filter === 'Yearly')
                                        <span
                                            class="-my-[0.275rem] ms-1 inline-block rounded-md bg-[#684AE2] bg-opacity-10 px-1 py-[0.275rem] text-[#684AE2]">{{ $fSectSettings?->pricing_save_percent }}</span>
                                    @endif
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($plansSubscriptionMonthly->count() > 0)
                    <div
                        class="subscription-plan-grid grid scroll-mt-28 grid-cols-4 gap-3 max-lg:grid-cols-2 max-md:grid-cols-1"
                        id="monthly"
                        x-data="{}"
                        :class="{ grid: $store.plansFilter.isActive('Monthly'), hidden: !$store.plansFilter.isActive('Monthly') }"
                    >
                        @foreach ($plansSubscriptionMonthly as $plan)
                            <div @class([
                                'lqd-price-table subscription-plan-card w-full rounded-3xl border bg-background',
                                'subscription-plan-card--featured shadow-[0_7px_20px_rgba(0,0,0,0.04)]' => $plan->is_featured,
                            ])>
                                <div class="flex h-full flex-col p-7">
                                    <div class="mb-2 flex flex-wrap text-[50px] font-bold leading-none text-heading-foreground">
                                        {!! displayPlanPrice($plan, $currency) !!}
                                        <div class="ms-2 mt-2 inline-flex flex-col items-start gap-2 text-[0.3em]">
                                            {{ __(formatCamelCase($plan->frequency)) }}
                                            @if ($plan->is_featured == 1)
                                                <div class="inline-flex rounded-full bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] px-3 py-1 text-3xs text-black">
                                                    {{ __('Popular plan') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-sm font-medium leading-none opacity-50">
                                        {{ __($plan->name) }}
                                    </p>

                                    <x-plan-details-card
                                        :plan="$plan"
                                        :period="$plan->frequency"
                                    />

                                    @if ($activesubid == $plan->id)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-green-500">
                                                    <b>{{ __('Already Subscribed') }}</b>
                                                </span>
                                                <x-button
                                                    size="lg"
                                                    variant="danger"
                                                    onclick="return confirm('Are you sure to cancel your plan? You will lose your remaining usage.');"
                                                    href="{{ route('dashboard.user.payment.cancelActiveSubscription') }}"
                                                >
                                                    {{ __('Cancel Subscription') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    @elseif($activesubid != null)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-foreground/60">
                                                    <b>{{ __('You have an active subscription.') }}</b>
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-7 text-center">
                                            @if ($is_active_gateway == 1)
                                                @php($planid = $plan->id)
                                                @if ($plan->price == 0)
                                                    <x-button
                                                        class="w-full"
                                                        href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => 'freeservice']) }}"
                                                        onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Choose plan') }}
                                                    </x-button>
                                                @elseif($lastPrivateDate)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'The expiration date for this plan has passed.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Expired') }}
                                                    </x-button>
                                                @elseif($maxSubscribe)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'This plan has reached its maximum capacity.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Limit reached') }}
                                                    </x-button>
                                                @else
                                                    @if (count($activeGateways) == 1 || setting('single_page_checkout', 0))
                                                        @php($gateway = $activeGateways->first())
                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                        <x-button
                                                            class="w-full"
                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                            variant="ghost-shadow"
                                                        >
                                                            {{ __('Choose plan') }}
                                                        </x-button>
                                                    @else
                                                        <x-modal
                                                            title="{{ __('Continue with') }}"
                                                            disable-modal="{{ $app_is_demo }}"
                                                            disable-modal-message="{{ __('This feature is disabled in Demo version.') }}"
                                                        >
                                                            <x-slot:trigger
                                                                class="w-full"
                                                                variant="ghost-shadow"
                                                            >
                                                                {{ __('Choose plan') }}
                                                            </x-slot:trigger>
                                                            <x-slot:modal>
                                                                <div class="flex flex-col gap-4">
                                                                    @foreach ($activeGateways as $gateway)
                                                                        @if ($gateway->code == 'revenuecat')
                                                                            @continue
                                                                        @endif
                                                                        @php($planid = $plan->id)
                                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                                        <x-button
                                                                            class="w-full"
                                                                            hover-variant="secondary"
                                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                                            variant="ghost-shadow"
                                                                        >
                                                                            <div class="m-0 flex h-9 w-full items-center justify-between align-middle">
                                                                                @if ($data['whiteLogo'] == 1)
                                                                                    <img
                                                                                        class="rounded-3xl bg-primary px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @else
                                                                                    <img
                                                                                        class="rounded-3xl px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @endif
                                                                                {{ $data['title'] }}
                                                                            </div>
                                                                        </x-button>
                                                                    @endforeach
                                                                </div>
                                                            </x-slot:modal>
                                                        </x-modal>
                                                    @endif
                                                @endif
                                            @else
                                                <p>{{ __('Please enable a payment gateway') }}</p>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($prepaidplans->count() > 0)
                    <div
                        class="subscription-plan-grid hidden scroll-mt-28 grid-cols-4 gap-3 max-lg:grid-cols-2 max-md:grid-cols-1"
                        id="pre-paid"
                        x-data="{}"
                        :class="{ grid: $store.plansFilter.isActive('Pre-Paid'), hidden: !$store.plansFilter.isActive('Pre-Paid') }"
                    >
                        @foreach ($prepaidplans as $plan)
                            <div @class([
                                'lqd-price-table subscription-plan-card w-full rounded-3xl border bg-background',
                                'subscription-plan-card--featured shadow-[0_7px_20px_rgba(0,0,0,0.04)]' => $plan->is_featured,
                            ])>
                                <div class="flex h-full flex-col p-7">
                                    <div class="mb-2 flex flex-wrap text-[50px] font-bold leading-none text-heading-foreground">
                                        {!! displayPlanPrice($plan, $currency) !!}
                                        <div class="ms-2 mt-2 inline-flex flex-col items-start gap-2 text-[0.3em]">
                                            {{ __('One time') }}
                                            @if ($plan->is_featured == 1)
                                                <div
                                                    class="inline-flex rounded-full bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] px-[0.75rem] py-[0.25rem] text-3xs text-black">
                                                    {{ __('Popular pack') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-sm font-medium leading-none opacity-60">
                                        {{ __($plan->name) }}
                                    </p>
                                    <x-plan-details-card
                                        :plan="$plan"
                                        :period="$plan->frequency"
                                    />
                                    <div class="mt-7 text-center">
                                        @if ($is_active_gateway == 1)
                                            @php($planid = $plan->id)
                                            @if ($plan->price == 0)
                                                <x-button
                                                    class="w-full"
                                                    href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startPrepaidPaymentProcess', ['planId' => $planid, 'gatewayCode' => 'freeservice']) }}"
                                                    onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                    variant="ghost-shadow"
                                                >
                                                    {{ __('Choose pack') }}
                                                </x-button>
                                            @elseif($lastPrivateDate)
                                                <x-button
                                                    class="w-full"
                                                    onclick="{{ 'return toastr.info(\'The expiration date for this plan has passed.\')' }}"
                                                    variant="ghost-shadow"
                                                >
                                                    {{ __('Expired') }}
                                                </x-button>
                                            @elseif($maxSubscribe)
                                                <x-button
                                                    class="w-full"
                                                    onclick="{{ 'return toastr.info(\'This plan has reached its maximum capacity.\')' }}"
                                                    variant="ghost-shadow"
                                                >
                                                    {{ __('Limit reached') }}
                                                </x-button>
                                            @else
                                                @if (count($activeGateways) == 1 || setting('single_page_checkout', 0))
                                                    @php($gateway = $activeGateways->first())
                                                    @php($data = $gatewayControls->gatewayData($gateway->code))
                                                    <x-button
                                                        class="w-full"
                                                        href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startPrepaidPaymentProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                        onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Choose pack') }}
                                                    </x-button>
                                                @else
                                                    <x-modal
                                                        title="{{ __('Continue with') }}"
                                                        disable-modal="{{ $app_is_demo }}"
                                                        disable-modal-message="{{ __('This feature is disabled in Demo version.') }}"
                                                    >
                                                        <x-slot:trigger
                                                            class="w-full"
                                                            variant="ghost-shadow"
                                                        >
                                                            {{ __('Choose pack') }}
                                                        </x-slot:trigger>
                                                        <x-slot:modal>
                                                            <div class="flex flex-col gap-4">
                                                                @foreach ($activeGateways as $gateway)
                                                                    @if ($gateway->code == 'revenuecat')
                                                                        @continue
                                                                    @endif
                                                                    @php($data = $gatewayControls->gatewayData($gateway->code))
                                                                    <x-button
                                                                        class="w-full"
                                                                        hover-variant="secondary"
                                                                        href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startPrepaidPaymentProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                                        onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                                        variant="ghost-shadow"
                                                                    >
                                                                        <div class="flex h-9 w-full items-center justify-between align-middle">
                                                                            @if ($data['whiteLogo'] == 1)
                                                                                <img
                                                                                    class="rounded-3xl bg-primary px-3"
                                                                                    src="{{ custom_theme_url($data['img']) }}"
                                                                                    style="max-height:24px;"
                                                                                    alt="{{ $data['title'] }}"
                                                                                />
                                                                            @else
                                                                                <img
                                                                                    class="rounded-3xl px-3"
                                                                                    src="{{ custom_theme_url($data['img']) }}"
                                                                                    style="max-height:24px;"
                                                                                    alt="{{ $data['title'] }}"
                                                                                />
                                                                            @endif
                                                                            {{ $data['title'] }}
                                                                        </div>
                                                                    </x-button>
                                                                @endforeach
                                                            </div>
                                                        </x-slot:modal>
                                                    </x-modal>
                                                @endif
                                            @endif
                                        @else
                                            <p>
                                                {{ __('Please enable a payment gateway') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($plansSubscriptionLifetime->count() > 0)
                    <div
                        class="subscription-plan-grid grid scroll-mt-28 grid-cols-4 gap-3 max-lg:grid-cols-2 max-md:grid-cols-1"
                        id="lifetime"
                        x-data="{}"
                        :class="{ grid: $store.plansFilter.isActive('Lifetime'), hidden: !$store.plansFilter.isActive('Lifetime') }"
                    >
                        @foreach ($plansSubscriptionLifetime as $plan)
                            <div @class([
                                'lqd-price-table subscription-plan-card w-full rounded-3xl border bg-background',
                                'subscription-plan-card--featured shadow-[0_7px_20px_rgba(0,0,0,0.04)]' => $plan->is_featured,
                            ])>
                                <div class="flex h-full flex-col p-7">
                                    <div class="mb-2 flex flex-wrap text-[50px] font-bold leading-none text-heading-foreground">
                                        {!! displayPlanPrice($plan, $currency) !!}
                                        <div class="ms-2 mt-2 inline-flex flex-col items-start gap-2 text-[0.3em]">
                                            {{ __(formatCamelCase($plan->frequency)) }}
                                            @if ($plan->is_featured == 1)
                                                <div class="inline-flex rounded-full bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] px-3 py-1 text-3xs text-black">
                                                    {{ __('Popular plan') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-sm font-medium leading-none opacity-50">
                                        {{ __($plan->name) }}
                                    </p>
                                    <x-plan-details-card
                                        :plan="$plan"
                                        :period="$plan->frequency"
                                    />

                                    @if ($activesubid == $plan->id)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-green-500">
                                                    <b>{{ __('Already Subscribed') }}</b>
                                                </span>
                                                <x-button
                                                    size="lg"
                                                    variant="danger"
                                                    onclick="return confirm('Are you sure to cancel your plan? You will lose your remaining usage.');"
                                                    href="{{ route('dashboard.user.payment.cancelActiveSubscription') }}"
                                                >
                                                    {{ __('Cancel Subscription') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    @elseif($activesubid != null)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-foreground/60">
                                                    <b>{{ __('You have an active subscription.') }}</b>
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-7 text-center">
                                            @if ($is_active_gateway == 1)
                                                @php($planid = $plan->id)
                                                @if ($plan->price == 0)
                                                    <x-button
                                                        class="w-full"
                                                        href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => 'freeservice']) }}"
                                                        onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Choose plan') }}
                                                    </x-button>
                                                @elseif($lastPrivateDate)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'The expiration date for this plan has passed.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Expired') }}
                                                    </x-button>
                                                @elseif($maxSubscribe)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'This plan has reached its maximum capacity.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Limit reached') }}
                                                    </x-button>
                                                @else
                                                    @if (count($activeGateways) == 1 || setting('single_page_checkout', 0))
                                                        @php($gateway = $activeGateways->first())
                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                        <x-button
                                                            class="w-full"
                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                            variant="ghost-shadow"
                                                        >
                                                            {{ __('Choose plan') }}
                                                        </x-button>
                                                    @else
                                                        <x-modal
                                                            title="{{ __('Continue with') }}"
                                                            disable-modal="{{ $app_is_demo }}"
                                                            disable-modal-message="{{ __('This feature is disabled in Demo version.') }}"
                                                        >
                                                            <x-slot:trigger
                                                                class="w-full"
                                                                variant="ghost-shadow"
                                                            >
                                                                {{ __('Choose plan') }}
                                                            </x-slot:trigger>
                                                            <x-slot:modal>
                                                                <div class="flex flex-col gap-4">
                                                                    @foreach ($activeGateways as $gateway)
                                                                        @if ($gateway->code == 'revenuecat')
                                                                            @continue
                                                                        @endif
                                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                                        <x-button
                                                                            class="w-full"
                                                                            hover-variant="secondary"
                                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                                            variant="ghost-shadow"
                                                                        >
                                                                            <div class="m-0 flex h-9 w-full items-center justify-between align-middle">
                                                                                @if ($data['whiteLogo'] == 1)
                                                                                    <img
                                                                                        class="rounded-3xl bg-primary px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @else
                                                                                    <img
                                                                                        class="rounded-3xl px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @endif
                                                                                {{ $data['title'] }}
                                                                            </div>
                                                                        </x-button>
                                                                    @endforeach
                                                                </div>
                                                            </x-slot:modal>
                                                        </x-modal>
                                                    @endif
                                                @endif
                                            @else
                                                <p>{{ __('Please enable a payment gateway') }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($plansSubscriptionAnnual->count() > 0)
                    <div
                        class="subscription-plan-grid grid scroll-mt-28 grid-cols-4 gap-3 max-lg:grid-cols-2 max-md:grid-cols-1"
                        id="yearly"
                        x-data="{}"
                        :class="{ grid: $store.plansFilter.isActive('Yearly'), hidden: !$store.plansFilter.isActive('Yearly') }"
                    >
                        @foreach ($plansSubscriptionAnnual as $plan)
                            <div @class([
                                'lqd-price-table subscription-plan-card w-full rounded-3xl border bg-background',
                                'subscription-plan-card--featured shadow-[0_7px_20px_rgba(0,0,0,0.04)]' => $plan->is_featured,
                            ])>
                                <div class="flex h-full flex-col p-7">
                                    <div class="mb-2 flex flex-wrap text-[50px] font-bold leading-none text-heading-foreground">
                                        {!! displayPlanPrice($plan, $currency) !!}
                                        <div class="ms-2 mt-2 inline-flex flex-col items-start gap-2 text-[0.3em]">
                                            {{ __(formatCamelCase($plan->frequency)) }}
                                            @if ($plan->is_featured == 1)
                                                <div class="inline-flex rounded-full bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] px-3 py-1 text-3xs text-black">
                                                    {{ __('Popular plan') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-sm font-medium leading-none opacity-50">
                                        {{ __($plan->name) }}
                                    </p>

                                    <x-plan-details-card
                                        :plan="$plan"
                                        :period="$plan->frequency"
                                    />

                                    @if ($activesubid == $plan->id)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-green-500">
                                                    <b>{{ __('Already Subscribed') }}</b>
                                                </span>
                                                <x-button
                                                    size="lg"
                                                    variant="danger"
                                                    onclick="return confirm('Are you sure to cancel your plan? You will lose your remaining usage.');"
                                                    href="{{ route('dashboard.user.payment.cancelActiveSubscription') }}"
                                                >
                                                    {{ __('Cancel Subscription') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    @elseif($activesubid != null)
                                        <div class="mt-7 text-center">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-foreground/60">
                                                    <b>{{ __('You have an active subscription.') }}</b>
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-7 text-center">
                                            @if ($is_active_gateway == 1)
                                                @php($planid = $plan->id)
                                                @if ($plan->price == 0)
                                                    <x-button
                                                        class="w-full"
                                                        href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => 'freeservice']) }}"
                                                        onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Choose plan') }}
                                                    </x-button>
                                                @elseif($lastPrivateDate)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'The expiration date for this plan has passed.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Expired') }}
                                                    </x-button>
                                                @elseif($maxSubscribe)
                                                    <x-button
                                                        class="w-full"
                                                        onclick="{{ 'return toastr.info(\'This plan has reached its maximum capacity.\')' }}"
                                                        variant="ghost-shadow"
                                                    >
                                                        {{ __('Limit reached') }}
                                                    </x-button>
                                                @else
                                                    @if (count($activeGateways) == 1 || setting('single_page_checkout', 0))
                                                        @php($gateway = $activeGateways->first())
                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                        <x-button
                                                            class="w-full"
                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code'] ?: 'stripe']) }}"
                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                            variant="ghost-shadow"
                                                        >
                                                            {{ __('Choose plan') }}
                                                        </x-button>
                                                    @else
                                                        <x-modal
                                                            title="{{ __('Continue with') }}"
                                                            disable-modal="{{ $app_is_demo }}"
                                                            disable-modal-message="{{ __('This feature is disabled in Demo version.') }}"
                                                        >
                                                            <x-slot:trigger
                                                                class="w-full"
                                                                variant="ghost-shadow"
                                                            >
                                                                {{ __('Choose plan') }}
                                                            </x-slot:trigger>
                                                            <x-slot:modal>
                                                                <div class="flex flex-col gap-4">
                                                                    @foreach ($activeGateways as $gateway)
                                                                        @if ($gateway->code == 'revenuecat')
                                                                            @continue
                                                                        @endif
                                                                        @php($data = $gatewayControls->gatewayData($gateway->code))
                                                                        <x-button
                                                                            class="w-full"
                                                                            hover-variant="secondary"
                                                                            href="{{ $app_is_demo ? '#' : route('dashboard.user.payment.startSubscriptionProcess', ['planId' => $planid, 'gatewayCode' => $data['code']]) }}"
                                                                            onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                                                            variant="ghost-shadow"
                                                                        >
                                                                            <div class="m-0 flex h-9 w-full items-center justify-between align-middle">
                                                                                @if ($data['whiteLogo'] == 1)
                                                                                    <img
                                                                                        class="rounded-3xl bg-primary px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @else
                                                                                    <img
                                                                                        class="rounded-3xl px-3"
                                                                                        src="{{ custom_theme_url($data['img']) }}"
                                                                                        style="max-height:24px;"
                                                                                        alt="{{ $data['title'] }}"
                                                                                    />
                                                                                @endif
                                                                                {{ $data['title'] }}
                                                                            </div>
                                                                        </x-button>
                                                                    @endforeach
                                                                </div>
                                                            </x-slot:modal>
                                                        </x-modal>
                                                    @endif
                                                @endif
                                            @else
                                                <p>{{ __('Please enable a payment gateway') }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let plan = '{{ request('plan') }}';

            if (plan) {
                $('#gatewayModal_' + plan).modal('show');
            }
        });

        document.addEventListener('alpine:init', () => {
            Alpine.store('plansFilter', {
                active: 'monthly',
                toggle(filter) {
                    const f = filter.replace('#', '').toLowerCase();
                    if (this.active === f) return;
                    this.active = f;
                    setTimeout(() => {
                        const el = document.getElementById(this.active);
                        if (el) {
                            el.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }, 0);
                },
                isActive(filter) {
                    const f = filter.replace('#', '').toLowerCase();
                    return this.active === f;
                },
                tabsClicked() {
                    return this.active !== 'monthly'
                }
            })
        })
    </script>
@endpush
