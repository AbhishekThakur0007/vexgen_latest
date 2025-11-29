@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', 'Manage Scheduled Posts')
@section('titlebar_title')
    <span class="scheduled-posts-page-title">
        {{ __('Manage Scheduled Posts') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('View and manage your scheduled social media posts') }}
@endsection
@section('titlebar_actions')
    <x-button
        href="{{ route('dashboard.user.automation.index') }}"
        variant="ghost-shadow"
        class="scheduled-posts-action-btn"
    >
        <x-tabler-plus class="size-4" />
        {{ __('Create New Scheduled Post') }}
    </x-button>
@endsection

@push('css')
    <link
        href="{{ custom_theme_url('/assets/libs/datepicker/air-datepicker.css') }}"
        rel="stylesheet"
    />
    <script src="{{ custom_theme_url('/assets/libs/datepicker/air-datepicker.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/datepicker/locale/en.js') }}"></script>

    <link
        href="{{ custom_theme_url('/assets/libs/picker/picker.css') }}"
        rel="stylesheet"
    />
    <script src="{{ custom_theme_url('/assets/libs/picker/picker.js') }}"></script>

    <style>
        .air-datepicker {
            width: 100% !important;
        }

        .air-datepicker-cell.-selected- {
            background: #330582 !important;
        }

        .air-datepicker-cell {
            border-radius: 50% !important;
            width: 32px !important;
            justify-self: center !important;
        }

        .air-datepicker.-inline- {
            border-color: lavenderblush !important;
        }

        /* Scheduled Posts Page Background - Matching Chatbot Theme */
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
        #rocket-stars-scheduled-posts {
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
        .scheduled-posts-page-title {
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
            .scheduled-posts-page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .scheduled-posts-page-title {
                font-size: 1.75rem;
            }
        }

        /* Table Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-table,
        body[data-theme="marketing-bot-dashboard"] table {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-table th,
        body[data-theme="marketing-bot-dashboard"] table th {
            color: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2) !important;
            background: rgba(0, 212, 255, 0.05) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-table td,
        body[data-theme="marketing-bot-dashboard"] table td {
            color: rgba(255, 255, 255, 0.8) !important;
            border-bottom: 1px solid rgba(0, 212, 255, 0.1) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-table tr:hover,
        body[data-theme="marketing-bot-dashboard"] table tr:hover {
            background: rgba(0, 212, 255, 0.05) !important;
        }

        /* System Time Styling */
        body[data-theme="marketing-bot-dashboard"] .py-10 p {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .py-10 p strong {
            color: rgba(0, 212, 255, 0.9) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* Button Icons Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-btn svg,
        body[data-theme="marketing-bot-dashboard"] button svg {
            filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.6));
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-btn:hover svg,
        body[data-theme="marketing-bot-dashboard"] button:hover svg {
            filter: drop-shadow(0 0 12px rgba(0, 212, 255, 0.9));
            transform: scale(1.1);
        }

        /* Modal Styling */
        body[data-theme="marketing-bot-dashboard"] .modal-content {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 212, 255, 0.2) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .modal-header {
            border-bottom: 1px solid rgba(0, 212, 255, 0.2) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .modal-title {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .modal-body label,
        body[data-theme="marketing-bot-dashboard"] .modal-body .text-neutral-900 {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .modal-footer {
            border-top: 1px solid rgba(0, 212, 255, 0.2) !important;
        }

        /* Create New Button Styling */
        .scheduled-posts-action-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        .scheduled-posts-action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        .scheduled-posts-action-btn svg {
            filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.6));
            transition: all 0.3s ease;
        }

        .scheduled-posts-action-btn:hover svg {
            filter: drop-shadow(0 0 12px rgba(0, 212, 255, 0.9));
            transform: scale(1.1);
        }

        /* Dropdown Select Styling - Matching Theme */
        body[data-theme="marketing-bot-dashboard"] #mperiod,
        body[data-theme="marketing-bot-dashboard"] select.form-select {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 8px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 10px 40px 10px 15px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            backdrop-filter: blur(10px) saturate(180%) !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3), 0 0 15px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2300d4ff' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 12px !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mperiod:hover,
        body[data-theme="marketing-bot-dashboard"] select.form-select:hover {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 212, 255, 0.2) !important;
            transform: translateY(-1px) !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mperiod:focus,
        body[data-theme="marketing-bot-dashboard"] select.form-select:focus {
            outline: none !important;
            border-color: rgba(0, 212, 255, 0.7) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.5), 0 0 25px rgba(0, 212, 255, 0.3) !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mperiod option,
        body[data-theme="marketing-bot-dashboard"] select.form-select option {
            background: rgba(10, 14, 39, 0.98) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 10px 15px !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mperiod option:hover,
        body[data-theme="marketing-bot-dashboard"] select.form-select option:hover {
            background: rgba(0, 212, 255, 0.2) !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mperiod option:checked,
        body[data-theme="marketing-bot-dashboard"] select.form-select option:checked {
            background: rgba(0, 212, 255, 0.3) !important;
            color: rgba(0, 212, 255, 1) !important;
        }

        /* Time Input Field Styling - Matching Theme */
        body[data-theme="marketing-bot-dashboard"] #mtime,
        body[data-theme="marketing-bot-dashboard"] .js-time-picker,
        body[data-theme="marketing-bot-dashboard"] input.form-control.js-time-picker {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 8px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 12px 15px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            backdrop-filter: blur(10px) saturate(180%) !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3), 0 0 15px rgba(0, 212, 255, 0.1) !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mtime::placeholder,
        body[data-theme="marketing-bot-dashboard"] .js-time-picker::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mtime:hover,
        body[data-theme="marketing-bot-dashboard"] .js-time-picker:hover {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 212, 255, 0.2) !important;
            transform: translateY(-1px) !important;
        }

        body[data-theme="marketing-bot-dashboard"] #mtime:focus,
        body[data-theme="marketing-bot-dashboard"] .js-time-picker:focus {
            outline: none !important;
            border-color: rgba(0, 212, 255, 0.7) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.5), 0 0 25px rgba(0, 212, 255, 0.3) !important;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
        }

        /* Time Label Styling */
        body[data-theme="marketing-bot-dashboard"] .modal-body .text-neutral-900 {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .modal-body .font-['Inter V'] {
            color: rgba(255, 255, 255, 0.9) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-scheduled-posts"></div>
    
    <div class="py-10 relative z-10">
        <p class="mb-4">
            {{ __('Current System Time:') }} <strong>{{ now()->format('H:i:s') }}</strong>
        </p>
        <x-table>
            <x-slot:head>
                <tr>
                    <th>{{ __('Platform') }}</th>
                    <th>{{ __('Products/Services') }}</th>
                    <th>{{ __('Campagin') }}</th>
                    <th>{{ __('Schedule Time') }}</th>
                    <th>{{ __('Period') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </x-slot:head>

            <x-slot:body>
                @forelse (auth()->user()->scheduledPosts ?? [] as $entry)
                    @php
                        $services = [];
                        $services = explode(',', str_replace(['(', ')'], '', $entry?->products));
                    @endphp

                    <tr>
                        <td> {{ $entry?->platform == 1 ? 'Twitter/X' : ($entry->platform == 2 ? 'LinkedIn' : 'Instagram') }} </td>

                        <td>
                            @foreach ($services ?? [] as $service)
                                @php
                                    [$key, $value] = explode(':', $service);
                                @endphp
                                <p class="m-0">{{ $key }}: {{ $value }}</p>
                            @endforeach
                        </td>

                        <td>{{ $entry?->campaign_name }}</td>

                        <td>{{ $entry?->repeat_time }}</td>

                        <td>
                            @switch($entry?->repeat_period)
                                @case('day')
                                    Daily
                                @break

                                @case('month')
                                    Monthly
                                @break

                                @case('week')
                                    Weekly
                                @break

                                @default
                                    unknow
                            @endswitch

                        </td>

                        <td class="whitespace-nowrap">
                            @if (env('APP_STATUS') == 'Demo')
                                <x-button
                                    class="size-9"
                                    variant="ghost-shadow"
                                    size="none"
                                    onclick="return toastr.info('This feature is disabled in Demo version.')"
                                    title="{{ __('Edit') }}"
                                >
                                    <x-tabler-pencil class="size-4" />
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
                                    class="size-9 edit-button"
                                    data-id="{{ $entry->id }}"
                                    data-platform="{{ $entry->platform }}"
                                    data-period="{{ $entry->repeat_period }}"
                                    data-time="{{ $entry->repeat_time }}"
                                    data-date="{{ $entry->repeat_start_date }}"
                                    data-repeated="{{ $entry->is_repeated }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    variant="ghost-shadow"
                                    size="none"
                                    title="{{ __('Edit') }}"
                                >
                                    <x-tabler-pencil class="size-4" />
                                </x-button>
                                <x-button
                                    class="size-9 delete-button"
                                    variant="ghost-shadow"
                                    hover-variant="danger"
                                    size="none"
                                    href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.automation.delete', $entry->id)) }}"
                                    onclick="return  confirm('{{ __('Are you sure? This is permanent.') }}')"
                                    title="{{ __('Delete') }}"
                                >
                                    <x-tabler-x class="size-4" />
                                </x-button>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td
                                class="text-center"
                                colspan="8"
                            >
                                {{ __('There is no scheduled posts yet') }}
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <!-- Editing post Modal -->
        <div
            class="modal fade"
            id="editModal"
            tabindex="-1"
            aria-labelledby="editModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="editModalLabel"
                        >{{ __('Edit Scheduled Post') }}</h5>
                    </div>
                    <form
                        id="editForm"
                        method="post"
                        action="#"
                    >
                        <div class="modal-body">
                            @csrf

                            <div class="row mb-[15px]">
                                <div class="mb-3 flex flex-wrap content-between">
                                    <div class="flex flex-1 items-start justify-start gap-2 px-4 pb-0 pt-3">
                                        <label class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                id="mrepeated"
                                                name="repeat"
                                                type="checkbox"
                                            >
                                        </label>
                                        <div class="font-['Inter V'] m-0 self-center text-sm font-medium leading-none text-neutral-900">{{ __('Repeat?') }}
                                            <x-info-tooltip text="{{ __('') }}" />
                                        </div>
                                    </div>

                                    <select
                                        class="form-select align-self-end mx-4 w-auto flex-1 content-end justify-self-end pe-4"
                                        id="mperiod"
                                        style="height: fit-content; min-height: 42px;"
                                        name="repeat_period"
                                        required
                                    >
                                        <option value="day">{{ __('Every Day') }}</option>
                                        <option value="week">{{ __('Every Week') }}</option>
                                        <option value="month">{{ __('Every Month') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-[15px]">
                                <div
                                    class="w-100 mb-3 inline-flex flex-col items-center justify-start gap-3 px-4"
                                    id="el"
                                >
                                    <input
                                        id="hiddenDateInput"
                                        type="hidden"
                                        name="date"
                                    >
                                </div>

                            </div>

                            <div class="row mb-[15px]">

                                <div class="w-100 mb-3 inline-flex flex-col items-start justify-start gap-3 px-4">
                                    <div class="inline-flex items-center justify-start gap-2">
                                        <div class="flex items-center justify-center gap-2 rounded">
                                            <div class="font-['Inter V'] text-base font-medium leading-none">{{ __('Time') }} ({{ config('app.timezone') }})

                                            </div>
                                        </div>
                                    </div>
                                    <input
                                        class="form-control js-time-picker"
                                        id="mtime"
                                        type="text"
                                        name="time"
                                        value="02:56"
                                    >
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                type="button"
                            >{{ __('Close') }}</button>
                            <button
                                class="btn btn-primary"
                                type="submit"
                            >{{ __('Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script src="{{ custom_theme_url('/assets/libs/datepicker/air-datepicker.js') }}"></script>
        <script src="{{ custom_theme_url('/assets/libs/datepicker/locale/en.js') }}"></script>
        <script src="{{ custom_theme_url('/assets/libs/picker/picker.js') }}"></script>
        <script>
            $(document).ready(function() {
                "use strict";

                var airDatepicker = new AirDatepicker('#el', {
                    locale: defaultLocale,
                    minDate: new Date(),
                    onSelect({
                        date,
                        formattedDate,
                        datepicker
                    }) {
                        const hiddenInput = document.getElementById('hiddenDateInput');
                        hiddenInput.value = formattedDate;
                    }
                });


                new Picker(document.querySelector('.js-time-picker'), {
                    format: 'HH:mm',
                    headers: true,
                    text: {
                        title: '{{ __('Pick a time') }}',
                    },
                });


                $('.edit-button').on('click', function() {
                    var rowId = $(this).data('id');
                    var period = $(this).data('period');

                    var time = $(this).data('time');
                    console.log(time);
                    var timeWithoutSeconds = time.split(':').slice(0, 2).join(':');

                    var date = $(this).data('date');
                    var repeated = $(this).data('repeated');

                    $('#mperiod').val(period);
                    $('#mtime').val(timeWithoutSeconds);
                    airDatepicker.selectDate(new Date(date));
                    repeated == 1 ? $('#mrepeated').prop('checked', true) : $('#mrepeated').prop('checked', false);

                    var editForm = $('#editForm');
                    var actionUrl = "{{ route('dashboard.user.automation.edit', ':id') }}";
                    actionUrl = actionUrl.replace(':id', rowId);
                    editForm.attr('action', actionUrl);
                });

                // Prevent form submission if action is not set
                $('#editForm').on('submit', function(e) {
                    var action = $(this).attr('action');
                    if (!action || action === '#' || action === '') {
                        e.preventDefault();
                        toastr.error('{{ __('Please select a post to edit first.') }}');
                        return false;
                    }
                });

            });
        </script>

        <script>
            // Interactive Stars Background for Scheduled Posts Page
            let scheduledPostsStars = [];
            let scheduledPostsMouseX = 0;
            let scheduledPostsMouseY = 0;
            
            function createScheduledPostsStars() {
                const starsContainer = document.getElementById('rocket-stars-scheduled-posts');
                if (!starsContainer) return;
                
                const starCount = 100;
                scheduledPostsStars = [];
                
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
                    scheduledPostsStars.push(star);
                }
                
                // Track mouse movement
                document.addEventListener('mousemove', function(e) {
                    const starsContainer = document.getElementById('rocket-stars-scheduled-posts');
                    if (!starsContainer) return;
                    
                    const rect = starsContainer.getBoundingClientRect();
                    scheduledPostsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                    scheduledPostsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                    
                    updateScheduledPostsStars();
                });
                
                // Initialize stars
                updateScheduledPostsStars();
            }
            
            function updateScheduledPostsStars() {
                scheduledPostsStars.forEach(star => {
                    const starX = parseFloat(star.dataset.x);
                    const starY = parseFloat(star.dataset.y);
                    
                    // Calculate distance from mouse
                    const dx = scheduledPostsMouseX - starX;
                    const dy = scheduledPostsMouseY - starY;
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
                createScheduledPostsStars();
            });
            
            // Re-initialize if content is loaded dynamically
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', createScheduledPostsStars);
            } else {
                createScheduledPostsStars();
            }
        </script>
    @endpush
