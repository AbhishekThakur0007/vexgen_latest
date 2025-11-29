@extends('ai-social-media::automation-steps.layout')

@push('css')
<style>
	/* Modern Platform Button Styling */
	.platform-button-modern {
		background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
		border: 1px solid rgba(0, 212, 255, 0.2) !important;
		backdrop-filter: blur(10px);
		transition: all 0.3s ease;
		position: relative;
		overflow: hidden;
		color: rgba(255, 255, 255, 0.9) !important;
	}

	.platform-button-modern::before {
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
	}

	.platform-button-modern:hover::before {
		opacity: 1;
	}

	.platform-button-modern:hover {
		transform: translateY(-3px);
		border-color: rgba(0, 212, 255, 0.4) !important;
		box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 212, 255, 0.2) !important;
	}

	.platform-button-modern.lqd-is-active {
		background: linear-gradient(135deg, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
		border-color: rgba(0, 212, 255, 0.5) !important;
		box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.3) !important;
	}

	@keyframes rotate {
		from { transform: rotate(0deg); }
		to { transform: rotate(360deg); }
	}

	/* Modern Icon Container */
	.platform-icon-container {
		background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(123, 47, 247, 0.15) 50%, rgba(0, 255, 136, 0.1) 100%) !important;
		border: 2px solid rgba(0, 212, 255, 0.3) !important;
		box-shadow: 0 0 20px rgba(0, 212, 255, 0.3), inset 0 0 10px rgba(123, 47, 247, 0.2);
		transition: all 0.3s ease;
	}

	.platform-button-modern.lqd-is-active .platform-icon-container {
		background: radial-gradient(circle, rgba(0, 212, 255, 0.3) 0%, rgba(123, 47, 247, 0.3) 50%, rgba(0, 255, 136, 0.2) 100%) !important;
		border-color: rgba(0, 212, 255, 0.6) !important;
		box-shadow: 0 0 30px rgba(0, 212, 255, 0.5), inset 0 0 15px rgba(123, 47, 247, 0.3);
		transform: scale(1.1);
	}

	/* Platform Logo Styling */
	.platform-logo {
		filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.5));
		transition: all 0.3s ease;
	}

	.platform-button-modern:hover .platform-logo {
		filter: drop-shadow(0 0 15px rgba(0, 212, 255, 0.8));
		transform: scale(1.1);
	}

	/* Modern Next Button */
	.next-button-modern {
		background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
		border: 1px solid rgba(0, 212, 255, 0.4) !important;
		color: rgba(0, 212, 255, 0.9) !important;
		transition: all 0.3s ease;
	}

	.next-button-modern:hover {
		background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
		border-color: rgba(0, 212, 255, 0.6) !important;
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
	}

	/* Connect Button Styling */
	.connect-button-modern {
		background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
		border: 1px solid rgba(0, 212, 255, 0.4) !important;
		color: rgba(0, 212, 255, 0.9) !important;
		transition: all 0.3s ease;
	}

	.connect-button-modern:hover {
		background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
		border-color: rgba(0, 212, 255, 0.6) !important;
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
	}

	/* Section Title Styling */
	.section-title-modern {
		color: rgba(255, 255, 255, 0.95);
		font-weight: 600;
		text-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
	}

	.section-description {
		color: rgba(255, 255, 255, 0.7);
	}
</style>
@endpush

@section('yield_content')
	<div class="mb-8 border-b border-foreground/10 pb-6">
		<h3 class="mb-5 flex flex-wrap items-center justify-between gap-3 section-title-modern">
			@lang('Select a Platform')
			<x-button
				class="ms-auto connect-button-modern"
				variant="secondary"
				href="{{ route('dashboard.user.automation.platform.list') }}"
			>
				{{ __('Connect Your Accounts') }}
			</x-button>
		</h3>
		<p class="section-description">
			@lang('Choose the social media platforms you would like to pubish your post. Feel free to select multiple platforms at once.')
		</p>
	</div>

	<form
		class="flex flex-col gap-6"
		id="stepsForm"
		action="{{ route('dashboard.user.automation.step.second') }}"
		method="POST"
	>
		@csrf
		<input
			type="hidden"
			name="automation"
			value="{{ time() }}"
		>

		<input
			type="hidden"
			name="platform_id"
		/>
		<input
			type="hidden"
			name="step"
			value="2"
		/>
		<input
			type="hidden"
			name="automation_step"
			value="two"
		/>
		<div class="flex flex-col gap-5">

			@foreach($platforms as $platform)
				@if(! $platform->has_setting)
					@continue
				@endif

				@php
					$is_connected = $platform->setting;
					$connectionMessage = $is_connected ? __('Connected') : __('Not Connected');
					if ($is_connected) {
						if ($is_connected->expires_at && $is_connected->expires_at->isPast()) {
							$is_connected = false;
							$connectionMessage = __('Session Expired');
						}
					}
				@endphp
				<button
					class="font-sm group relative flex h-full w-full items-center gap-4 rounded-[20px] px-3 py-2.5 font-medium platform-button-modern"
					type="button"
					onclick="handleButtonClick(this, {{ $platform->id }}, {{ $is_connected }});"
				>
                <span
					class="size-9 inline-grid place-items-center rounded-full platform-icon-container">
                    <x-tabler-check
						class="size-5 hidden group-[&.lqd-is-active]:block text-[#00d4ff]"
						stroke-width="1.5"
						style="filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.8));"
					/>
                </span>
					<span class="text-white/90 font-medium">{{ $platform->name }}</span>
					<img
						class="max-w-6 max-h-6 platform-logo"
						src="/{{ $platform->logo }}"
					/>
					<span @class([
                    'gap-1.5 items-center flex ms-auto text-[12px]',
                    'flex' => $is_connected,
                    'hidden' => ! $is_connected,
                ])>
                    <span
						class="size-2 inline-block rounded-full bg-green-500"
						style="box-shadow: 0 0 8px rgba(34, 197, 94, 0.8);"
						aria-hidden="true"
					></span>
                    <span class="text-green-400">@lang($connectionMessage)</span>
                </span>
				</button>
			@endforeach
			<x-button
				variant="secondary"
				class="next-button-modern"
				onclick="goNextStep();"
				type="submit"
			>
				{{ __('Next') }}
				<span class="size-7 inline-grid place-items-center rounded-full bg-background text-foreground">
                <x-tabler-chevron-right class="size-4"/>
            </span>
			</x-button>
		</div>
	</form>

@endsection

@push('script')
	<script>
		let selectedButton = null; // Initialize a variable to keep track of the selected button
		let selectedPlatformId = null;
		let is_connected_main = false;

		function handleButtonClick(button, platformId, is_connected) {
			var buttons = document.querySelectorAll('button');
			buttons.forEach(function (btn) {
				btn.classList.toggle('lqd-is-active', false);
			});

			button.classList.toggle('lqd-is-active');
			is_connected_main = is_connected;

			if (selectedButton === button) {
				// If the same button is clicked
				selectedButton = null;
				selectedPlatformId = null;

			} else {
				selectedButton = button;
				selectedPlatformId = platformId;
				// platform_id
				document.querySelector('input[name="platform_id"]').value = platformId;
			}
		}

		function goNextStep() {

			if (!selectedPlatformId) {
				event.preventDefault();
				toastr.error("{{ __('No platform selected.') }}");
			}

			if (!is_connected_main) {
				event.preventDefault();
				toastr.error("{{ __('Please connect with the platform first.') }}");
			}
		}
	</script>

@endpush
