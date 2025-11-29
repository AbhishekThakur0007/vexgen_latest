@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Campaigns'))
@section('titlebar_title')
    <span class="social-campaign-page-title">
        {{ __('Campaigns') }}
    </span>
@endsection

@push('css')
    <style>
        /* Social Campaign Page Background - Matching Dashboard Theme */
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
        #rocket-stars-social-campaign {
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
        .social-campaign-page-title {
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
            .social-campaign-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .social-campaign-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Table Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-table,
        body[data-theme="marketing-bot-dashboard"] table {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-table th,
        body[data-theme="marketing-bot-dashboard"] table th,
        body[data-theme="marketing-bot-dashboard"] thead th {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600 !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-table td,
        body[data-theme="marketing-bot-dashboard"] table td,
        body[data-theme="marketing-bot-dashboard"] tbody td {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-table tr:hover,
        body[data-theme="marketing-bot-dashboard"] table tbody tr:hover {
            background: rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Modal Styling */
        body[data-theme="marketing-bot-dashboard"] [class*="modal"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="modal"] [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="modal"] h3,
        body[data-theme="marketing-bot-dashboard"] [class*="modal"] p {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] input,
        body[data-theme="marketing-bot-dashboard"] textarea,
        body[data-theme="marketing-bot-dashboard"] select {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.25) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border-radius: 0.5rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] input:focus,
        body[data-theme="marketing-bot-dashboard"] textarea:focus,
        body[data-theme="marketing-bot-dashboard"] select:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3) !important;
            background: rgba(10, 14, 39, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] input::placeholder,
        body[data-theme="marketing-bot-dashboard"] textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Labels */
        body[data-theme="marketing-bot-dashboard"] label,
        body[data-theme="marketing-bot-dashboard"] [class*="label"] {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Buttons */
        body[data-theme="marketing-bot-dashboard"] button,
        body[data-theme="marketing-bot-dashboard"] .lqd-button {
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Add Campaign Button */
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] .lqd-button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] .lqd-button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Submit Button */
        body[data-theme="marketing-bot-dashboard"] [type="submit"],
        body[data-theme="marketing-bot-dashboard"] button[type="submit"] {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [type="submit"]:hover,
        body[data-theme="marketing-bot-dashboard"] button[type="submit"]:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5) !important;
        }
    </style>
@endpush

@section('titlebar_actions')
    <x-modal
        class:modal-body="pt-0"
        class:modal-head="border-none"
    >
        <x-slot:trigger>
            <x-tabler-plus class="size-4" />
            @lang('Add Campaign')
        </x-slot:trigger>

        <x-slot:modal>
            <h3 class="mb-3">
                @lang('Create a Campaign')
            </h3>
            <p class="mb-8 max-w-[520px] font-medium text-heading-foreground/70">
                @lang('Explain your audience aligning with your content and specific goals such as brand awareness, lead generation, education, etc.')
            </p>
            <form
                class="space-y-5"
                id="campaignForm"
                action="{{ route('dashboard.user.social-media.campaign.store') }}"
                method="post"
            >
                <x-forms.input
                    class:label="text-heading-foreground"
                    id="cam_name"
                    name="cam_name"
                    label="{{ __('Campaign Name') }}"
                    required
                    size="lg"
                />

                <x-forms.input
                    class:label-extra="flex shrink-0"
                    class:label="text-heading-foreground"
                    id="cam_target"
                    label="{{ __('Who is your target audience for this content?') }}"
                    rows="4"
                    name="cam_target"
                    type="textarea"
                    placeholder="{{ __('Please provide details about their demographics, interests and pain-points.') }}"
                >
                    <x-slot:label-extra>
                        <x-button
                            class="size-7 cursor-pointer items-center justify-center p-0 text-xs font-semibold leading-relaxed hover:bg-heading-foreground/20 hover:shadow-xl hover:shadow-primary/30"
                            id="generateCamContentModal"
                            type="button"
                            variant="ghost-shadow"
                        >
                            <x-tabler-refresh
                                class="lds-dual-ring2 hidden size-4 animate-spin"
                                id="lds-dual-ring2"
                            />
                            {{-- blade-formatter-disable --}}
                            <svg class="generate2" width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" > <path fill-rule="evenodd" clip-rule="evenodd" d="M25.3483 15.0849L23.9529 15.3678C23.2806 15.5042 22.6635 15.8356 22.1785 16.3207C21.6934 16.8057 21.362 17.4229 21.2256 18.0951L20.9426 19.4905C20.9147 19.6301 20.8392 19.7556 20.7291 19.8458C20.619 19.936 20.4811 19.9853 20.3388 19.9853C20.1964 19.9853 20.0585 19.936 19.9484 19.8458C19.8383 19.7556 19.7629 19.6301 19.7349 19.4905L19.4519 18.0951C19.3156 17.4228 18.9843 16.8056 18.4992 16.3205C18.0142 15.8355 17.3969 15.5041 16.7246 15.3678L15.3292 15.0849C15.19 15.0564 15.0648 14.9807 14.9749 14.8706C14.885 14.7604 14.8359 14.6226 14.8359 14.4805C14.8359 14.3384 14.885 14.2006 14.9749 14.0905C15.0648 13.9803 15.19 13.9046 15.3292 13.8762L16.7246 13.5932C17.3969 13.4569 18.0142 13.1255 18.4992 12.6405C18.9843 12.1554 19.3156 11.5382 19.4519 10.8659L19.7349 9.47048C19.7629 9.33094 19.8383 9.20539 19.9484 9.11519C20.0585 9.025 20.1964 8.97571 20.3388 8.97571C20.4811 8.97571 20.619 9.025 20.7291 9.11519C20.8392 9.20539 20.9147 9.33094 20.9426 9.47048L21.2256 10.8659C21.362 11.5381 21.6934 12.1553 22.1785 12.6403C22.6635 13.1254 23.2806 13.4568 23.9529 13.5932L25.3483 13.8762C25.4876 13.9046 25.6127 13.9803 25.7026 14.0905C25.7925 14.2006 25.8416 14.3384 25.8416 14.4805C25.8416 14.6226 25.7925 14.7604 25.7026 14.8706C25.6127 14.9807 25.4876 15.0564 25.3483 15.0849ZM15.1421 22.1572L14.763 22.2342C14.2954 22.3291 13.8662 22.5595 13.5288 22.8969C13.1915 23.2342 12.961 23.6634 12.8662 24.131L12.7892 24.5102C12.7679 24.6164 12.7105 24.7119 12.6267 24.7806C12.5429 24.8492 12.438 24.8867 12.3297 24.8867C12.2214 24.8867 12.1164 24.8492 12.0326 24.7806C11.9488 24.7119 11.8914 24.6164 11.8701 24.5102L11.7931 24.131C11.6983 23.6634 11.4678 23.2342 11.1305 22.8969C10.7931 22.5595 10.3639 22.3291 9.89634 22.2342L9.51718 22.1572C9.41098 22.1359 9.31543 22.0785 9.24678 21.9947C9.17813 21.911 9.14062 21.806 9.14062 21.6977C9.14062 21.5894 9.17813 21.4844 9.24678 21.4006C9.31543 21.3169 9.41098 21.2594 9.51718 21.2382L9.89634 21.1612C10.3639 21.0663 10.7931 20.8358 11.1305 20.4985C11.4678 20.1611 11.6983 19.7319 11.7931 19.2644L11.8701 18.8852C11.8914 18.779 11.9488 18.6834 12.0326 18.6148C12.1164 18.5461 12.2214 18.5087 12.3297 18.5087C12.438 18.5087 12.5429 18.5461 12.6267 18.6148C12.7105 18.6834 12.7679 18.779 12.7892 18.8852L12.8662 19.2644C12.961 19.7319 13.1915 20.1611 13.5288 20.4985C13.8662 20.8358 14.2954 21.0663 14.763 21.1612L15.1421 21.2382C15.2483 21.2594 15.3439 21.3169 15.4125 21.4006C15.4812 21.4844 15.5187 21.5894 15.5187 21.6977C15.5187 21.806 15.4812 21.911 15.4125 21.9947C15.3439 22.0785 15.2483 22.1359 15.1421 22.1572Z" fill="url(#paint0_linear_2401_1456)" /> <defs> <linearGradient id="paint0_linear_2401_1456" x1="25.8416" y1="16.9312" x2="8.97735" y2="14.9877" gradientUnits="userSpaceOnUse" > <stop stop-color="#8D65E9" /> <stop offset="0.483" stop-color="#5391E4" /> <stop offset="1" stop-color="#6BCD94" /> </linearGradient> </defs> </svg>
							{{-- blade-formatter-enable --}}
                        </x-button>
                    </x-slot:label-extra>
                </x-forms.input>

                <input
                    type="hidden"
                    name="generate_campaign_url"
                    value="{{ route('dashboard.user.social-media.campaign.generate') }}"
                >

                <x-button
                    class="w-full"
                    type="submit"
                    variant="secondary"
                >
                    @lang('Add')
                    <span class="inline-grid size-7 place-content-center rounded-full bg-background">
                        <x-tabler-chevron-right class="size-4" />
                    </span>
                </x-button>
            </form>
        </x-slot:modal>
    </x-modal>
@endsection

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-social-campaign"></div>
    
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
                    {{ __('Target Audience') }}
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
                            {{ $item->target_audience }}
                        </td>
                        <td class="whitespace-nowrap text-end">
                            @if ($app_is_demo)
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
                                    variant="ghost-shadow"
                                    hover-variant="danger"
                                    size="none"
                                    href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.social-media.campaign.destroy', $item->id)) }}"
                                    onclick="return confirm('{{ __('Are you sure? This is permanent.') }}')"
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
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $('#campaignForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();

                $.post(url, data, function(data) {}).done(function(data) {
                    if (data) {
                        toastr.success(data.message);
                        window.location.reload();
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }).fail(function(e) {
                    if (e?.responseJSON?.message) {
                        toastr.error(e.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong!');
                    }
                });
            });
        });
    </script>
    <script>
        const stream_type = '{!! $settings_two->openai_default_stream_server !!}';
        const openai_model = '{{ $setting->openai_default_model }}';

        const guest_id = document.getElementById("guest_id")?.value;
        const guest_event_id = document.getElementById("guest_event_id")?.value;
        const guest_look_id = document.getElementById("guest_look_id")?.value;
        const guest_product_id = document.getElementById("guest_product_id")?.value;
    </script>
    <script src="{{ custom_theme_url('/assets/custom/custom_generate.js') }}"></script>
    
    <script>
        // Interactive Stars Background for Social Campaign Page
        let socialCampaignStars = [];
        let socialCampaignMouseX = 0;
        let socialCampaignMouseY = 0;
        
        function createSocialCampaignStars() {
            const starsContainer = document.getElementById('rocket-stars-social-campaign');
            if (!starsContainer) return;
            
            const starCount = 100;
            socialCampaignStars = [];
            
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
                socialCampaignStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-social-campaign');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                socialCampaignMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                socialCampaignMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateSocialCampaignStars();
            });
            
            // Initialize stars
            updateSocialCampaignStars();
        }
        
        function updateSocialCampaignStars() {
            socialCampaignStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = socialCampaignMouseX - starX;
                const dy = socialCampaignMouseY - starY;
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
            createSocialCampaignStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createSocialCampaignStars);
        } else {
            createSocialCampaignStars();
        }
    </script>
@endpush
