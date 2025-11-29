@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Brand Voice'))
@section('titlebar_title')
    <span class="brand-voice-page-title">
        {{ __('Brand Voice') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('Generate AI content exclusive to your brand and eliminate the need for repetitive introductions of your company.') }}
@endsection
@section('titlebar_actions')
	<x-button href="{{ route('dashboard.user.brand.create') }}">
		<x-tabler-plus class="size-4" />
		{{ __('New Company') }}
	</x-button>
@endsection

@push('css')
    <style>
        /* Brand Voice Page Background - Matching Dashboard Theme */
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
        #rocket-stars-brand-voice {
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
        .brand-voice-page-title {
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
            .brand-voice-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .brand-voice-page-title {
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
    <div class="rocket-stars-background" id="rocket-stars-brand-voice"></div>
    
	<div class="py-10 relative z-10">
		<x-table>
			<x-slot:head>
				<tr>
					<th>
						{{ __('Name') }}
					</th>
					<th class="text-end">
						{{ __('Action') }}
					</th>
				</tr>
			</x-slot:head>

			<x-slot:body>
				@foreach ($list as $entry)
					<tr>
						<td>
							{{ $entry->name }}
						</td>

						<td class="whitespace-nowrap text-end">
							<x-button
								class="size-9"
								variant="ghost-shadow"
								size="none"
								href="{{  (route('dashboard.user.brand.edit', $entry->id)) }}"
								title="{{ __('Edit') }}"
							>
								<x-tabler-pencil class="size-4" />
							</x-button>
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
									onclick="return confirm('{{ __('Are you sure? This is permanent and will delete all documents related to user.') }}')"
									href="{{  (route('dashboard.user.brand.delete', $entry->id)) }}"
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
        // Interactive Stars Background for Brand Voice Page
        let brandVoiceStars = [];
        let brandVoiceMouseX = 0;
        let brandVoiceMouseY = 0;
        
        function createBrandVoiceStars() {
            const starsContainer = document.getElementById('rocket-stars-brand-voice');
            if (!starsContainer) return;
            
            const starCount = 100;
            brandVoiceStars = [];
            
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
                brandVoiceStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-brand-voice');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                brandVoiceMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                brandVoiceMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateBrandVoiceStars();
            });
            
            // Initialize stars
            updateBrandVoiceStars();
        }
        
        function updateBrandVoiceStars() {
            brandVoiceStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = brandVoiceMouseX - starX;
                const dy = brandVoiceMouseY - starY;
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
            createBrandVoiceStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createBrandVoiceStars);
        } else {
            createBrandVoiceStars();
        }
    </script>
@endpush
