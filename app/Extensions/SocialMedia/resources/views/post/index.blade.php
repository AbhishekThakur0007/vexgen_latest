@php
    use App\Extensions\SocialMedia\System\Enums\PlatformEnum;

    $sort_buttons = [
        [
            'label' => __('Date'),
            'sort' => 'created_at',
        ],
        [
            'label' => __('Status'),
            'sort' => 'status',
        ],
        [
            'label' => __('Platform'),
            'sort' => 'platform',
        ],
    ];

    $filter_buttons = [
        [
            'label' => __('All'),
            'filter' => 'all',
        ],
    ];

    $filter = request()->query('filter', 'all');

    foreach ($platforms as $platform) {
        $filter_buttons[] = [
            'label' => str($platform->name)->title(),
            'filter' => $platform->name,
        ];
    }
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Social Media Posts'))
@section('titlebar_title')
    <span class="social-posts-page-title">
        {{ __('Social Media Posts') }}
    </span>
@endsection

@push('css')
    <style>
        /* Social Posts Page Background - Matching Dashboard Theme */
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
        #rocket-stars-social-posts {
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
        .social-posts-page-title {
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
            .social-posts-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .social-posts-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Filter Buttons */
        body[data-theme="marketing-bot-dashboard"] .lqd-filter-btn,
        body[data-theme="marketing-bot-dashboard"] [class*="filter-btn"] {
            background: rgba(10, 14, 39, 0.6) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-filter-btn:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="filter-btn"]:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-filter-btn.active,
        body[data-theme="marketing-bot-dashboard"] [class*="filter-btn"].active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Sort Dropdown */
        body[data-theme="marketing-bot-dashboard"] [class*="dropdown"] button,
        body[data-theme="marketing-bot-dashboard"] [role="menu"] {
            background: rgba(10, 14, 39, 0.95) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="dropdown"] button:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [role="menu"] button,
        body[data-theme="marketing-bot-dashboard"] .lqd-sort-list button {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border: none !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [role="menu"] button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-sort-list button:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [role="menu"] button.active,
        body[data-theme="marketing-bot-dashboard"] .lqd-sort-list button.active {
            background: rgba(0, 212, 255, 0.2) !important;
        }
        
        /* View Toggle Buttons */
        body[data-theme="marketing-bot-dashboard"] .lqd-view-toggle-trigger {
            background: rgba(10, 14, 39, 0.6) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-view-toggle-trigger:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-view-toggle-trigger.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Posts Container/Table */
        body[data-theme="marketing-bot-dashboard"] .lqd-social-posts-head,
        body[data-theme="marketing-bot-dashboard"] [class*="posts-head"] {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-post-item,
        body[data-theme="marketing-bot-dashboard"] [class*="posts-item"] {
            background: rgba(10, 14, 39, 0.6) !important;
            border-color: rgba(0, 212, 255, 0.15) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-social-media-post-item:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="posts-item"]:hover {
            background: rgba(0, 212, 255, 0.1) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2), 
                        0 0 10px rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Grid View Cards */
        body[data-theme="marketing-bot-dashboard"] [data-view-mode="grid"] .lqd-social-media-post-item {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 
                        0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [data-view-mode="grid"] .lqd-social-media-post-item:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 
                        0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-title,
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-date,
        body[data-theme="marketing-bot-dashboard"] .lqd-posts-item-likes,
        body[data-theme="marketing-bot-dashboard"] p {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="text-foreground"] {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Status Badges */
        body[data-theme="marketing-bot-dashboard"] [class*="posts-item-type"] {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Modal Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-modal-post-backdrop {
            background: rgba(0, 0, 0, 0.7) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-modal-post-content {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-modal-post-content a[class*="rounded-full"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 29, 58, 0.95)) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-modal-post-content a[class*="rounded-full"]:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Pagination */
        body[data-theme="marketing-bot-dashboard"] .pagination,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination .page-link,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] a {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination .page-link:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] a:hover {
            background: rgba(0, 212, 255, 0.2) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(0, 212, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .pagination .page-item.active .page-link,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] .active a {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Create Post Dropdown */
        body[data-theme="marketing-bot-dashboard"] [class*="create-post"] button,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] [class*="create-post"] button:hover,
        body[data-theme="marketing-bot-dashboard"] [class*="titlebar"] button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Empty State */
        body[data-theme="marketing-bot-dashboard"] h2 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
    </style>
@endpush

@section('titlebar_actions')
    @include('social-media::components.create-post-dropdown', ['platforms' => $platforms])
@endsection

@section('titlebar_after')
    <div class="flex flex-wrap items-center justify-between gap-2">
        <form
            class="lqd-filter-list flex flex-wrap items-center gap-x-4 gap-y-2 text-heading-foreground max-sm:gap-3"
            action="{{ route('dashboard.user.social-media.post.index', ['listOnly' => 'true']) }}"
            method="GET"
            x-init
            x-target="lqd-posts-container"
            @submit="$store.socialMediaPostsFilter.changePage('1')"
        >
            <input
                type="hidden"
                name="sort"
                :value="$store.socialMediaPostsFilter.sort"
            >
            <input
                type="hidden"
                name="page"
                value="1"
            >
            <input
                type="hidden"
                name="sortAscDesc"
                :value="$store.socialMediaPostsFilter.sortAscDesc"
            >
            @foreach ($filter_buttons as $button)
                <x-button
                    @class([
                        'lqd-filter-btn inline-flex rounded-full px-2.5 py-0.5 transition-colors hover:bg-foreground/5 [&.active]:bg-foreground/5 hover:translate-y-0 text-2xs leading-tight',
                        'active' => $filter == $button['filter'],
                    ])
                    tag="button"
                    type="submit"
                    name="filter"
                    value="{{ $button['filter'] }}"
                    variant="ghost"
                    ::class="{ active: $store.socialMediaPostsFilter.filter === '{{ $button['filter'] }}' }"
                    @click="$store.socialMediaPostsFilter.changeFilter('{{ $button['filter'] }}')"
                >
                    {{ $button['label'] }}
                </x-button>
            @endforeach
        </form>

        <div class="flex items-center gap-3">
            <x-dropdown.dropdown
                anchor="end"
                offsetY="1rem"
            >
                <x-slot:trigger
                    class="whitespace-nowrap px-2 py-1"
                    variant="link"
                    size="xs"
                >
                    {{ __('Sort by:') }}
                    <x-tabler-arrows-sort class="size-4 shrink-0" />
                </x-slot:trigger>

                <x-slot:dropdown
                    class="overflow-hidden text-2xs font-medium"
                >
                    <form
                        class="lqd-sort-list flex flex-col"
                        action="{{ route('dashboard.user.social-media.post.index', ['listOnly' => 'true']) }}"
                        method="GET"
                        x-init
                        x-target="lqd-posts-container"
                        @submit="$store.socialMediaPostsFilter.changePage('1')"
                    >
                        <input
                            type="hidden"
                            name="filter"
                            :value="$store.socialMediaPostsFilter.filter"
                        >
                        <input
                            type="hidden"
                            name="page"
                            value="1"
                        >
                        <input
                            type="hidden"
                            name="sortAscDesc"
                            :value="$store.socialMediaPostsFilter.sortAscDesc"
                        >
                        @foreach ($sort_buttons as $button)
                            <button
                                class="group flex w-full items-center gap-1 px-3 py-2 hover:bg-foreground/5 [&.active]:bg-foreground/5"
                                :class="$store.socialMediaPostsFilter.sort === '{{ $button['sort'] }}' && 'active'"
                                name="sort"
                                value="{{ $button['sort'] }}"
                                @click="$store.socialMediaPostsFilter.changeSort('{{ $button['sort'] }}')"
                            >
                                {{ $button['label'] }}
                                <x-tabler-caret-down-filled
                                    class="size-3 opacity-0 transition-all group-[&.active]:opacity-80"
                                    ::class="$store.socialMediaPostsFilter.sortAscDesc === 'asc' && 'rotate-180'"
                                />
                            </button>
                        @endforeach
                    </form>
                </x-slot:dropdown>
            </x-dropdown.dropdown>

            <div class='lqd-posts-view-toggle lqd-docs-view-toggle lqd-view-toggle relative z-1 flex w-full items-center gap-2 lg:ms-auto lg:justify-end')>
                <button
                    class="lqd-view-toggle-trigger inline-flex size-7 items-center justify-center rounded-md transition-colors hover:bg-foreground/5 [&.active]:bg-foreground/5"
                    :class="$store.socialMediaPostsViewMode.socialMediaPostsViewMode === 'list' && 'active'"
                    x-init
                    @click="$store.socialMediaPostsViewMode.change('list')"
                    title="List view"
                >
                    <x-tabler-list
                        class="size-5"
                        stroke-width="1.5"
                    />
                </button>
                <button
                    class="lqd-view-toggle-trigger inline-flex size-7 items-center justify-center rounded-md transition-colors hover:bg-foreground/5 [&.active]:bg-foreground/5"
                    :class="$store.socialMediaPostsViewMode.socialMediaPostsViewMode === 'grid' && 'active'"
                    x-init
                    @click="$store.socialMediaPostsViewMode.change('grid')"
                    title="Grid view"
                >
                    <x-tabler-layout-grid
                        class="size-5"
                        stroke-width="1.5"
                    />
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-social-posts"></div>
    
    <div class="py-10 relative z-10">
        @include('social-media::components.post.posts-container', ['posts' => $posts, 'filter' => $filter])
    </div>
@endsection
@push('script')
	<script>
		(() => {
			document.addEventListener('alpine:init', () => {
				Alpine.data('socialMediaPosts', () => ({
					modalOpen: false,
					loadingState: 'loading',
					prevPostUrl: null,
					nextPostUrl: null,
					async submitDuplicate() {
						let form = this.$refs.form;

						let formData = new FormData(form);
						try {
							let response = await fetch(formData.get('route'), {
								method: "POST",
								headers: {
									"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
									"Accept": "application/json"
								},
								body: formData // JSON yerine FormData nesnesini direkt gönderiyoruz
							});

							let result = await response.json();

							if (result.status === 'success') {
								toastr.success(result.message);
								window.location = `${result.redirect}`;
								this.setModalOpen(false);
							}else {
								toastr.error(result.message);
							}
						} catch (error) {
							console.error("Hata:", error);
						}
					},
					setModalOpen(state) {
						if (state === this.modalOpen) return;

						this.setLoadingState('loading');
						this.modalOpen = state;

						if (!this.modalOpen) {
							const url = new URL(window.location);
							url.searchParams.delete('show');
							window.history.replaceState({}, document.title, url);
						}
					},
					setLoadingState(state) {
						if (state === this.loadingState) return;

						this.loadingState = state;
					},
					onAjaxBefore() {
						this.$dispatch('modal:open');
						this.setLoadingState('loading');
					},
					onAjaxSuccess() {
						const { url } = this.$event.detail;
						this.setLoadingState('loaded');

						if (url) {
							const postId = url.split('/').pop();
							const newUrl = new URL(window.location);
							newUrl.searchParams.set('show', postId);
							window.history.replaceState({}, document.title, newUrl);
						}
					},
					onAjaxError() {
						this.$dispatch('modal:close');
						toastr.error('{{ __('Failed fetching post.') }}.');
					},
				}));
			});
		})();
	</script>
	
	<script>
        // Interactive Stars Background for Social Posts Page
        let socialPostsStars = [];
        let socialPostsMouseX = 0;
        let socialPostsMouseY = 0;
        
        function createSocialPostsStars() {
            const starsContainer = document.getElementById('rocket-stars-social-posts');
            if (!starsContainer) return;
            
            const starCount = 100;
            socialPostsStars = [];
            
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
                socialPostsStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-social-posts');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                socialPostsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                socialPostsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateSocialPostsStars();
            });
            
            // Initialize stars
            updateSocialPostsStars();
        }
        
        function updateSocialPostsStars() {
            socialPostsStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = socialPostsMouseX - starX;
                const dy = socialPostsMouseY - starY;
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
            createSocialPostsStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createSocialPostsStars);
        } else {
            createSocialPostsStars();
        }
    </script>
@endpush
