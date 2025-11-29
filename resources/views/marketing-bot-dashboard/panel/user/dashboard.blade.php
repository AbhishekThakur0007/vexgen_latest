@php
	$userId = auth()->id();
    $plan = Auth::user()->activePlan();
    $plan_type = 'regular';
    // $team = Auth::user()->getAttribute('team');
    $teamManager = Auth::user()->getAttribute('teamManager');

    if ($plan != null) {
        $plan_type = strtolower($plan->plan_type);
    }

    $titlebar_links = [
        [
            'label' => 'All',
            'link' => '#all',
        ],
        [
            'label' => 'Create Anything',
            'link' => '#search-anything',
        ],
        [
            'label' => 'Your Plan',
            'link' => '#plan',
        ],
        [
            'label' => 'Invite a Friend',
            'link' => '#invite',
        ],
        [
            'label' => 'Campaigns',
            'link' => '#campaign-stats',
        ],
        [
            'label' => 'Recent',
            'link' => '#recent',
        ],
        [
            'label' => 'Favorite Templates',
            'link' => '#templates',
        ],
    ];

    $premium_features = \App\Models\OpenAIGenerator::query()->where('active', 1)->where('premium', 1)->limit(5)->get()->pluck('title')->toArray();
    $user_is_premium = false;
    $plan = auth()->user()?->relationPlan;
    if ($plan) {
        $planType = strtolower($plan->plan_type ?? 'all');
        if ($plan->plan_type === 'all' || $plan->plan_type === 'premium') {
            $user_is_premium = true;
        }
    }

    $referral_enabled = $app_is_demo || (($setting->feature_affilates ?? true) && \auth()->user()?->affiliate_status == 1);

    $style_string = '';

    if (setting('announcement_background_color')) {
        $style_string .= '.lqd-card.lqd-announcement-card { background-color: ' . setting('announcement_background_color') . ';}';
    }

    if (setting('announcement_background_image')) {
        $style_string .= '.lqd-card.lqd-announcement-card { background-image: url(' . setting('announcement_background_image') . '); }';
    }

    if (setting('announcement_background_color_dark')) {
        $style_string .= '.theme-dark .lqd-card.lqd-announcement-card { background-color: ' . setting('announcement_background_color_dark') . ';}';
    }

    if (setting('announcement_background_image_dark')) {
        $style_string .= '.theme-dark .lqd-card.lqd-announcement-card { background-image: url(' . setting('announcement_background_image_dark') . '); }';
    }

	$favoriteOpenAis = cache("user:{$userId}:favorite_openai");
@endphp

@if (filled($style_string))
	@push('css')
		<style>
			{{ $style_string }}
		</style>
	@endpush
@endif

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __(''))

@section('content')
	{{-- XP Notification System --}}
	@include('marketing-bot-dashboard.components.xp-notification')
	
	{{-- Rocket Theme Dashboard --}}
	@include('panel.user.dashboard.rocket-dashboard')
	
	
@endsection

@push('script')
	@if ($app_is_not_demo)
		@includeFirst(['onboarding::include.introduction', 'panel.admin.onboarding.include.introduction', 'vendor.empty'])
		@includeFirst(['onboarding-pro::include.introduction', 'panel.admin.onboarding-pro.include.introduction', 'vendor.empty'])
	@endif
	@if (Route::has('dashboard.user.dash_notify_seen'))
		<script>
			function dismiss() {
				// localStorage.setItem('lqd-announcement-dismissed', true);
				document.querySelector('.lqd-announcement').style.display = 'none';
				$.ajax({
					url: '{{ route('dashboard.user.dash_notify_seen') }}',
					type: 'POST',
					data: {
						_token: '{{ csrf_token() }}'
					},
					success: function (response) {
						/* console.log(response); */
					}
				});
			}
		</script>
	@endif
@endpush
