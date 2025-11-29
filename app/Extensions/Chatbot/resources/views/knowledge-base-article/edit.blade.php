@extends('panel.layout.settings', ['disable_tblr' => true])
@section('title', $title)
@section('titlebar_title')
    <span class="knowledge-base-edit-page-title">
        {{ $title }}
    </span>
@endsection
@section('titlebar_subtitle', $description)
@section('titlebar_actions', '')

@push('css')
    <style>
        /* Knowledge Base Edit Page Background - Matching Chatbot Theme */
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
        #rocket-stars-knowledge-base-edit {
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
        .knowledge-base-edit-page-title {
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

        /* Responsive Title */
        @media (max-width: 768px) {
            .knowledge-base-edit-page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .knowledge-base-edit-page-title {
                font-size: 1.75rem;
            }
        }

        /* Settings Card Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-settings-card,
        body[data-theme="marketing-bot-dashboard"] .lqd-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }

        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-form input,
        body[data-theme="marketing-bot-dashboard"] .lqd-form textarea,
        body[data-theme="marketing-bot-dashboard"] .lqd-form select,
        body[data-theme="marketing-bot-dashboard"] input[type="text"],
        body[data-theme="marketing-bot-dashboard"] textarea,
        body[data-theme="marketing-bot-dashboard"] select {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-form input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-form textarea:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-form select:focus,
        body[data-theme="marketing-bot-dashboard"] input[type="text"]:focus,
        body[data-theme="marketing-bot-dashboard"] textarea:focus,
        body[data-theme="marketing-bot-dashboard"] select:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 29, 58, 0.95)) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-form input::placeholder,
        body[data-theme="marketing-bot-dashboard"] .lqd-form textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Form Labels Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-form label,
        body[data-theme="marketing-bot-dashboard"] label {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Save Button Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-btn[type="submit"],
        body[data-theme="marketing-bot-dashboard"] button[type="submit"] {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-btn[type="submit"]:hover,
        body[data-theme="marketing-bot-dashboard"] button[type="submit"]:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        /* Checkbox/Switch Styling */
        body[data-theme="marketing-bot-dashboard"] .form-check-input,
        body[data-theme="marketing-bot-dashboard"] input[type="checkbox"] {
            border-color: rgba(0, 212, 255, 0.3) !important;
        }

        body[data-theme="marketing-bot-dashboard"] .form-check-input:checked,
        body[data-theme="marketing-bot-dashboard"] input[type="checkbox"]:checked {
            background-color: rgba(0, 212, 255, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.8) !important;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* Links Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-form a,
        body[data-theme="marketing-bot-dashboard"] a {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-form a:hover,
        body[data-theme="marketing-bot-dashboard"] a:hover {
            color: rgba(0, 212, 255, 1) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        /* Text Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-form p,
        body[data-theme="marketing-bot-dashboard"] p {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
@endpush

@section('settings')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-knowledge-base-edit"></div>
    
    <div class="relative z-10">
    <form
        class="flex flex-col gap-10"
        action="{{ $action }}"
        method="post"
    >
        @csrf
        @method($method)

        <div class="mt-4 space-y-6">
            <x-forms.input
                id="title"
                size="lg"
                name="title"
                label="{{ __('Title') }}"
                placeholder="{{ __('Article Title') }}"
                value="{!! $item?->title !!}"
            />

            <x-forms.input
                id="description"
                size="lg"
                name="description"
                label="{{ __('Excerpt') }}"
                placeholder="{{ __('Enter a short description') }}"
                type="textarea"
                rows="3"
            >{{ $item?->description }}</x-forms.input>

            <div class="space-y-3">
                <x-forms.input
                    id="content"
                    size="lg"
                    name="content"
                    label="{{ __('Content') }}"
                    placeholder="## This is a heading.&#10;&#10;- List Item #1&#10;- List Item #2&#10;&#10;![This is an image!](https://example.com/link-to-image.jpg)&#10;&#10;This is an inline iframe video&#10;&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/aEiQ4T3XkNY?si=THuGPLSdlJFlHcx5&quot;&gt;&lt;/iframe&gt;"
                    type="textarea"
                    rows="15"
                >{{ $item?->content }}</x-forms.input>

                <p class="text-3xs">
                    {{ __('Use Markdown to add content.') }}
                    <a
                        class="underline"
                        href="https://www.markdownguide.org/cheat-sheet/"
                        target="_blank"
                    >
                        {{ __('Here is a guide how to use Markdown.') }}
                    </a>
                </p>
            </div>

            <x-forms.input
                class:label="text-heading-foreground"
                type="select"
                size="lg"
                name="chatbots[]"
                label="{{ __('Chatbots') }}"
                x-model="chatbots"
                multiple=""
            >
                @foreach ($chatbots as $chatbot)
                    <option
                        value="{{ $chatbot->id }}"
                        {{ in_array($chatbot->id, $item?->chatbots ?? []) ? 'selected' : '' }}
                    > {{ $chatbot->title }}</option>
                @endforeach
            </x-forms.input>

            <x-forms.input
                id="is_featured"
                name="is_featured"
                type="checkbox"
                switcher
                type="checkbox"
                :checked="(bool) $item?->is_featured"
                label="{{ __('Feature') }}"
            />

            @if ($app_is_demo)
                <x-button
                    class="w-full"
                    size="lg"
                    onclick="return toastr.info('This feature is disabled in Demo version.')"
                >
                    {{ __('Save') }}
                </x-button>
            @else
                <x-button
                    class="w-full"
                    size="lg"
                    type="submit"
                >
                    {{ __('Save') }}
                </x-button>
            @endif
        </div>
    </form>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Knowledge Base Edit Page
        let knowledgeBaseEditStars = [];
        let knowledgeBaseEditMouseX = 0;
        let knowledgeBaseEditMouseY = 0;
        
        function createKnowledgeBaseEditStars() {
            const starsContainer = document.getElementById('rocket-stars-knowledge-base-edit');
            if (!starsContainer) return;
            
            const starCount = 100;
            knowledgeBaseEditStars = [];
            
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
                knowledgeBaseEditStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-knowledge-base-edit');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                knowledgeBaseEditMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                knowledgeBaseEditMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateKnowledgeBaseEditStars();
            });
            
            // Initialize stars
            updateKnowledgeBaseEditStars();
        }
        
        function updateKnowledgeBaseEditStars() {
            knowledgeBaseEditStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = knowledgeBaseEditMouseX - starX;
                const dy = knowledgeBaseEditMouseY - starY;
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
            createKnowledgeBaseEditStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createKnowledgeBaseEditStars);
        } else {
            createKnowledgeBaseEditStars();
        }
    </script>
@endpush
