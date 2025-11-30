@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', $title)
@section('titlebar_title')
    <span class="knowledge-base-page-title">
        {{ $title }}
    </span>
@endsection
@section('titlebar_subtitle', $description)
@section('titlebar_actions')
    <x-button
        class="mb-4 knowledge-base-action-btn"
        variant="primary"
        href="{{ route('dashboard.chatbot.knowledge-base-article.create') }}"
    >
        {{ __('Add Article') }}
    </x-button>
@endsection

@push('css')
    <style>
        /* Knowledge Base Page Background - Matching Chatbot Theme */
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
        #rocket-stars-knowledge-base {
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
        .knowledge-base-page-title {
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
            padding: 7px !important;
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
            .knowledge-base-page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .knowledge-base-page-title {
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

        /* Add Article Button Styling */
        .knowledge-base-action-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        .knowledge-base-action-btn:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        .knowledge-base-action-btn svg {
            filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.6));
            transition: all 0.3s ease;
        }

        .knowledge-base-action-btn:hover svg {
            filter: drop-shadow(0 0 12px rgba(0, 212, 255, 0.9));
            transform: scale(1.1);
        }

        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-form input,
        body[data-theme="marketing-bot-dashboard"] .lqd-form textarea,
        body[data-theme="marketing-bot-dashboard"] .lqd-form select {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-form input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-form textarea:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-form select:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
        }

        /* Empty State Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-table td[colspan] {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Pagination Styling */
        body[data-theme="marketing-bot-dashboard"] .pagination,
        body[data-theme="marketing-bot-dashboard"] [class*="pagination"] {
            background: transparent !important;
        }

        body[data-theme="marketing-bot-dashboard"] .pagination a,
        body[data-theme="marketing-bot-dashboard"] .pagination button {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8), rgba(26, 29, 58, 0.8)) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .pagination a:hover,
        body[data-theme="marketing-bot-dashboard"] .pagination button:hover {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-knowledge-base"></div>
    
    <div class="py-10 relative z-10">
        <x-table>
            <x-slot:head>
                <tr>
                    <th>
                        {{ __('id') }}
                    </th>
                    <th>
                        {{ __('Title') }}
                    </th>
                    <th>
                        {{ __('Excerpt') }}
                    </th>
                    <th>
                        {{ __('Created At') }}
                    </th>
                    <th class="text-end">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </x-slot:head>

            <x-slot:body>
                @foreach ($items as $entry)
                    <tr id="template-{{ $entry->id }}">
                        <td>
                            {{ $entry->id }}
                        </td>
                        <td>
                            {{ __($entry->title) }}
                        </td>
                        <td>
                            <p class="m-0 max-w-48 overflow-hidden text-ellipsis whitespace-nowrap md:max-w-80">
                                {{ __($entry->description) }}
                            </p>
                        </td>
                        <td>
                            <p class="m-0">
                                {{ date('j.n.Y', strtotime($entry->updated_at)) }}
                                <span class="block opacity-60">
                                    {{ date('H:i:s', strtotime($entry->updated_at)) }}
                                </span>
                            </p>
                        </td>
                        <td class="whitespace-nowrap text-end">
                            <x-button
                                class="size-9"
                                size="none"
                                variant="ghost-shadow"
                                hover-variant="primary"
                                href="{{ route('dashboard.chatbot.knowledge-base-article.edit', $entry->id) }}"
                                title="{{ __('Edit') }}"
                            >
                                <x-tabler-pencil class="size-4" />
                            </x-button>
                            <form
                                method="POST"
                                action="{{ route('dashboard.chatbot.knowledge-base-article.destroy', $entry->id) }}"
                                style="display: inline;"
                            >
                                @csrf
                                @method('DELETE')
                                <x-button
                                    class="size-9"
                                    size="none"
                                    variant="ghost-shadow"
                                    hover-variant="danger"
                                    type="submit"
                                    onclick="return confirm('{{ __('Are you sure? This is permanent.') }}')"
                                    title="{{ __('Delete') }}"
                                >
                                    <x-tabler-x class="size-4" />
                                </x-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Knowledge Base Page
        let knowledgeBaseStars = [];
        let knowledgeBaseMouseX = 0;
        let knowledgeBaseMouseY = 0;
        
        function createKnowledgeBaseStars() {
            const starsContainer = document.getElementById('rocket-stars-knowledge-base');
            if (!starsContainer) return;
            
            const starCount = 100;
            knowledgeBaseStars = [];
            
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
                knowledgeBaseStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-knowledge-base');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                knowledgeBaseMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                knowledgeBaseMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateKnowledgeBaseStars();
            });
            
            // Initialize stars
            updateKnowledgeBaseStars();
        }
        
        function updateKnowledgeBaseStars() {
            knowledgeBaseStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = knowledgeBaseMouseX - starX;
                const dy = knowledgeBaseMouseY - starY;
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
            createKnowledgeBaseStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createKnowledgeBaseStars);
        } else {
            createKnowledgeBaseStars();
        }
    </script>
@endpush
