@php
    use App\Extensions\MarketingBot\System\Enums\CampaignStatus;
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', $title)
@section('titlebar_title')
    <span class="whatsapp-campaign-page-title">
        {{ $title }}
    </span>
@endsection

@section('titlebar_actions')
    <div class="flex gap-4 lg:justify-end">
        <x-button href="{{ route('dashboard.user.marketing-bot.whatsapp-campaign.create') }}">
            <x-tabler-plus class="size-4" />
            {{ __('Add campaign') }}
        </x-button>
    </div>
@endsection

@push('css')
    <style>
        /* WhatsApp Campaign Page Background - Matching Dashboard Theme */
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
        #rocket-stars-whatsapp-campaign {
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
        .whatsapp-campaign-page-title {
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
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .whatsapp-campaign-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .whatsapp-campaign-page-title {
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
        
        /* Status Badge Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-type {
            background: rgba(10, 14, 39, 0.5) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-type.text-green-500 {
            background: rgba(34, 197, 94, 0.15) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
            color: rgba(34, 197, 94, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-type.text-yellow-700 {
            background: rgba(234, 179, 8, 0.15) !important;
            border-color: rgba(234, 179, 8, 0.3) !important;
            color: rgba(234, 179, 8, 0.9) !important;
        }
        
        /* Pagination Styling */
        body[data-theme="marketing-bot-dashboard"] .pagination,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination a,
        body[data-theme="marketing-bot-dashboard"] .pagination button {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination a:hover,
        body[data-theme="marketing-bot-dashboard"] .pagination button:hover {
            background: rgba(0, 212, 255, 0.2) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination .active a,
        body[data-theme="marketing-bot-dashboard"] .pagination .active button {
            background: rgba(0, 212, 255, 0.3) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(0, 212, 255, 0.9) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .text-foreground {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-whatsapp-campaign"></div>
    
    <div class="py-10 relative z-10">
        <x-table>
            <x-slot:head>
                <th>
                    {{ __('ID') }}
                </th>
                <th>
                    {{ __('Name') }}
                </th>
                <th>
                    {{ __('Status') }}
                </th>

                <th>
                    {{ __('Training') }}
                </th>

                <th>
                    {{ __('Schedule at') }}
                </th>

                <th class="text-end">
                    {{ __('Action') }}
                </th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            {{ $item->id }}
                        </td>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            <p @class([
                                'lqd-posts-item-type sort-file inline-flex w-auto m-0 items-center gap-1.5 justify-self-start whitespace-nowrap rounded-full border px-2 py-1 text-[12px] font-medium leading-none',
                                'text-green-500' => $item['status'] === CampaignStatus::published,
                                'text-yellow-700' => $item['status'] === CampaignStatus::scheduled,
                            ])>
                                @if ($item['status'] === CampaignStatus::published)
                                    <x-tabler-check class="size-4" />
                                @elseif ($item['status'] === CampaignStatus::scheduled)
                                    <x-tabler-clock class="size-4" />
                                @else
                                    <x-tabler-circle-dashed class="size-4" />
                                @endif
                                @lang(str()->title($item->status->value))
                            </p>
                        </td>

                        <td>
                            @if ($item->embeddings_count)
                                <x-badge
                                    class="text-3xs"
                                    variant="success"
                                >
                                    {{ trans('Trained') }}
                                </x-badge>
                            @else
                                <x-badge
                                    class="text-3xs"
                                    variant="default"
                                >
                                    {{ trans('Not Trained') }}
                                </x-badge>
                            @endif
                        </td>
                        <td>
                            {{ $item->scheduled_at ? $item->scheduled_at->format('Y-m-d H:i') : __('Not scheduled') }}
                        </td>
                        <td class="whitespace-nowrap text-end">
                            @if ($app_is_demo)
                                <x-button
                                    class="size-9"
                                    variant="ghost-shadow"
                                    size="none"
                                    href="{{ route('dashboard.user.marketing-bot.train.index', $item->id) }}"
                                    title="{{ __('Training') }}"
                                >
                                    <svg
                                        width="17"
                                        height="16"
                                        viewBox="0 0 17 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        focusable="false"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M16.1681 6.15216L14.7761 6.43416V6.43616C14.1057 6.57221 13.4902 6.90274 13.0064 7.38647C12.5227 7.87021 12.1922 8.48572 12.0561 9.15617L11.7741 10.5482C11.7443 10.6852 11.6686 10.8079 11.5594 10.8958C11.4503 10.9838 11.3143 11.0318 11.1741 11.0318C11.0339 11.0318 10.8979 10.9838 10.7888 10.8958C10.6796 10.8079 10.6039 10.6852 10.5741 10.5482L10.2921 9.15617C10.1563 8.48561 9.82586 7.86997 9.34209 7.38619C8.85831 6.90241 8.24266 6.57197 7.57211 6.43616L6.18011 6.15416C6.0413 6.12574 5.91656 6.05026 5.82698 5.94048C5.7374 5.8307 5.68848 5.69336 5.68848 5.55166C5.68848 5.40997 5.7374 5.27263 5.82698 5.16285C5.91656 5.05307 6.0413 4.97759 6.18011 4.94916L7.57211 4.66716C8.24261 4.53124 8.85819 4.20076 9.34195 3.717C9.8257 3.23324 10.1562 2.61766 10.2921 1.94716L10.5741 0.555164C10.6039 0.418164 10.6796 0.295476 10.7888 0.207494C10.8979 0.119512 11.0339 0.0715332 11.1741 0.0715332C11.3143 0.0715332 11.4503 0.119512 11.5594 0.207494C11.6686 0.295476 11.7443 0.418164 11.7741 0.555164L12.0561 1.94716C12.1922 2.61761 12.5227 3.23312 13.0064 3.71686C13.4902 4.20059 14.1057 4.53112 14.7761 4.66716L16.1681 4.94716C16.3069 4.97559 16.4317 5.05107 16.5212 5.16085C16.6108 5.27063 16.6597 5.40797 16.6597 5.54966C16.6597 5.69136 16.6108 5.8287 16.5212 5.93848C16.4317 6.04826 16.3069 6.12374 16.1681 6.15216ZM5.98931 13.2052L5.61131 13.2822C5.14508 13.3767 4.71703 13.6055 4.38056 13.9418C4.04409 14.2781 3.81411 14.706 3.71931 15.1722L3.64231 15.5502C3.62171 15.6567 3.56468 15.7527 3.48102 15.8217C3.39735 15.8907 3.29227 15.9285 3.18381 15.9285C3.07534 15.9285 2.97026 15.8907 2.88659 15.8217C2.80293 15.7527 2.74591 15.6567 2.72531 15.5502L2.6483 15.1722C2.55362 14.7059 2.32368 14.2779 1.98719 13.9416C1.6507 13.6053 1.22258 13.3756 0.756305 13.2812L0.378305 13.2042C0.271814 13.1836 0.175815 13.1265 0.106785 13.0429C0.037755 12.9592 0 12.8541 0 12.7457C0 12.6372 0.037755 12.5321 0.106785 12.4485C0.175815 12.3648 0.271814 12.3078 0.378305 12.2872L0.756305 12.2102C1.22271 12.1157 1.65093 11.8858 1.98743 11.5493C2.32393 11.2128 2.5538 10.7846 2.6483 10.3182L2.72531 9.94016C2.74591 9.83367 2.80293 9.73767 2.88659 9.66864C2.97026 9.59961 3.07534 9.56186 3.18381 9.56186C3.29227 9.56186 3.39735 9.59961 3.48102 9.66864C3.56468 9.73767 3.62171 9.83367 3.64231 9.94016L3.71931 10.3182C3.81376 10.7847 4.04359 11.2131 4.38008 11.5497C4.71658 11.8864 5.14482 12.1165 5.61131 12.2112L5.98931 12.2882C6.0958 12.3088 6.1918 12.3658 6.26083 12.4495C6.32985 12.5331 6.36761 12.6382 6.36761 12.7467C6.36761 12.8551 6.32985 12.9602 6.26083 13.0439C6.1918 13.1275 6.0958 13.1846 5.98931 13.2052Z"
                                            fill="url(#paint0_linear_3314_1636)"
                                        />
                                        <defs>
                                            <linearGradient
                                                id="paint0_linear_3314_1636"
                                                x1="1.03221e-07"
                                                y1="3.30635"
                                                x2="13.3702"
                                                y2="15.6959"
                                                gradientUnits="userSpaceOnUse"
                                            >
                                                <stop stop-color="#82E2F4" />
                                                <stop
                                                    offset="0.502"
                                                    stop-color="#8A8AED"
                                                />
                                                <stop
                                                    offset="1"
                                                    stop-color="#6977DE"
                                                />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </x-button>
                                <x-button
                                    class="size-9"
                                    variant="ghost-shadow"
                                    size="none"
                                    onclick="return toastr.info('This feature is disabled in Demo version.')"
                                    title="{{ __('Edit') }}"
                                >
                                    <x-tabler-edit class="size-4" />
                                </x-button>
                                <x-button
                                    class="size-9"
                                    variant="ghost-shadow"
                                    hover-variant="danger"
                                    size="none"
                                    onclick="return toastr.info('This feature is disabled in Demo version.')"
                                    title="{{ __('Delete') }}"
                                >
                                    <x-tabler-x class="size-4" />
                                </x-button>
                            @else
                                <x-button
                                    class="size-9"
                                    href="{{ route('dashboard.user.marketing-bot.train.index', $item->id) }}"
                                    variant="ghost-shadow"
                                    size="none"
                                    title="{{ __('Training') }}"
                                >
                                    <svg
                                        width="17"
                                        height="16"
                                        viewBox="0 0 17 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        focusable="false"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M16.1681 6.15216L14.7761 6.43416V6.43616C14.1057 6.57221 13.4902 6.90274 13.0064 7.38647C12.5227 7.87021 12.1922 8.48572 12.0561 9.15617L11.7741 10.5482C11.7443 10.6852 11.6686 10.8079 11.5594 10.8958C11.4503 10.9838 11.3143 11.0318 11.1741 11.0318C11.0339 11.0318 10.8979 10.9838 10.7888 10.8958C10.6796 10.8079 10.6039 10.6852 10.5741 10.5482L10.2921 9.15617C10.1563 8.48561 9.82586 7.86997 9.34209 7.38619C8.85831 6.90241 8.24266 6.57197 7.57211 6.43616L6.18011 6.15416C6.0413 6.12574 5.91656 6.05026 5.82698 5.94048C5.7374 5.8307 5.68848 5.69336 5.68848 5.55166C5.68848 5.40997 5.7374 5.27263 5.82698 5.16285C5.91656 5.05307 6.0413 4.97759 6.18011 4.94916L7.57211 4.66716C8.24261 4.53124 8.85819 4.20076 9.34195 3.717C9.8257 3.23324 10.1562 2.61766 10.2921 1.94716L10.5741 0.555164C10.6039 0.418164 10.6796 0.295476 10.7888 0.207494C10.8979 0.119512 11.0339 0.0715332 11.1741 0.0715332C11.3143 0.0715332 11.4503 0.119512 11.5594 0.207494C11.6686 0.295476 11.7443 0.418164 11.7741 0.555164L12.0561 1.94716C12.1922 2.61761 12.5227 3.23312 13.0064 3.71686C13.4902 4.20059 14.1057 4.53112 14.7761 4.66716L16.1681 4.94716C16.3069 4.97559 16.4317 5.05107 16.5212 5.16085C16.6108 5.27063 16.6597 5.40797 16.6597 5.54966C16.6597 5.69136 16.6108 5.8287 16.5212 5.93848C16.4317 6.04826 16.3069 6.12374 16.1681 6.15216ZM5.98931 13.2052L5.61131 13.2822C5.14508 13.3767 4.71703 13.6055 4.38056 13.9418C4.04409 14.2781 3.81411 14.706 3.71931 15.1722L3.64231 15.5502C3.62171 15.6567 3.56468 15.7527 3.48102 15.8217C3.39735 15.8907 3.29227 15.9285 3.18381 15.9285C3.07534 15.9285 2.97026 15.8907 2.88659 15.8217C2.80293 15.7527 2.74591 15.6567 2.72531 15.5502L2.6483 15.1722C2.55362 14.7059 2.32368 14.2779 1.98719 13.9416C1.6507 13.6053 1.22258 13.3756 0.756305 13.2812L0.378305 13.2042C0.271814 13.1836 0.175815 13.1265 0.106785 13.0429C0.037755 12.9592 0 12.8541 0 12.7457C0 12.6372 0.037755 12.5321 0.106785 12.4485C0.175815 12.3648 0.271814 12.3078 0.378305 12.2872L0.756305 12.2102C1.22271 12.1157 1.65093 11.8858 1.98743 11.5493C2.32393 11.2128 2.5538 10.7846 2.6483 10.3182L2.72531 9.94016C2.74591 9.83367 2.80293 9.73767 2.88659 9.66864C2.97026 9.59961 3.07534 9.56186 3.18381 9.56186C3.29227 9.56186 3.39735 9.59961 3.48102 9.66864C3.56468 9.73767 3.62171 9.83367 3.64231 9.94016L3.71931 10.3182C3.81376 10.7847 4.04359 11.2131 4.38008 11.5497C4.71658 11.8864 5.14482 12.1165 5.61131 12.2112L5.98931 12.2882C6.0958 12.3088 6.1918 12.3658 6.26083 12.4495C6.32985 12.5331 6.36761 12.6382 6.36761 12.7467C6.36761 12.8551 6.32985 12.9602 6.26083 13.0439C6.1918 13.1275 6.0958 13.1846 5.98931 13.2052Z"
                                            fill="url(#paint0_linear_3314_1636)"
                                        />
                                        <defs>
                                            <linearGradient
                                                id="paint0_linear_3314_1636"
                                                x1="1.03221e-07"
                                                y1="3.30635"
                                                x2="13.3702"
                                                y2="15.6959"
                                                gradientUnits="userSpaceOnUse"
                                            >
                                                <stop stop-color="#82E2F4" />
                                                <stop
                                                    offset="0.502"
                                                    stop-color="#8A8AED"
                                                />
                                                <stop
                                                    offset="1"
                                                    stop-color="#6977DE"
                                                />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </x-button>
                                <x-button
                                    class="size-9"
                                    href="{{ route('dashboard.user.marketing-bot.whatsapp-campaign.edit', $item->id) }}"
                                    variant="ghost-shadow"
                                    size="none"
                                    title="{{ __('Edit') }}"
                                >
                                    <x-tabler-edit class="size-4" />
                                </x-button>
                                <x-button
                                    class="size-9"
                                    data-delete="delete"
                                    data-delete-link="{{ route('dashboard.user.marketing-bot.whatsapp-campaign.destroy', $item->id) }}"
                                    variant="ghost-shadow"
                                    hover-variant="danger"
                                    size="none"
                                    title="{{ __('Delete') }}"
                                >
                                    <x-tabler-x class="size-4" />
                                </x-button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <div class="mt-3 flex justify-end">
            {{ $items->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for WhatsApp Campaign Page
        let whatsappCampaignStars = [];
        let whatsappCampaignMouseX = 0;
        let whatsappCampaignMouseY = 0;
        
        function createWhatsappCampaignStars() {
            const starsContainer = document.getElementById('rocket-stars-whatsapp-campaign');
            if (!starsContainer) return;
            
            const starCount = 100;
            whatsappCampaignStars = [];
            
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
                whatsappCampaignStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-whatsapp-campaign');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                whatsappCampaignMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                whatsappCampaignMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateWhatsappCampaignStars();
            });
            
            // Initialize stars
            updateWhatsappCampaignStars();
        }
        
        function updateWhatsappCampaignStars() {
            whatsappCampaignStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = whatsappCampaignMouseX - starX;
                const dy = whatsappCampaignMouseY - starY;
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
            createWhatsappCampaignStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createWhatsappCampaignStars);
        } else {
            createWhatsappCampaignStars();
        }
    </script>
    
    <script>
        $('[data-delete="delete"]').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this campaign?')) {
                return;
            }

            let deleteLink = $(this).data('delete-link');

            $.ajax({
                url: deleteLink,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.status === 'success') {
                        toastr.success(data.message);

                        setTimeout(function() {
                            window.location.reload();
                        }, 600);

                        return;
                    }

                    if (data.message) {
                        toastr.error(data.message);
                        return;
                    }

                    toastr.error('Something went wrong!');
                },
                error: function(e) {
                    if (e?.responseJSON?.message) {
                        toastr.error(e.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>
@endpush
