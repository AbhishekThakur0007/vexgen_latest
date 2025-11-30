@php
    $sort_buttons = [
        [
            'label' => __('Date'),
            'sort' => 'created_at',
        ],
        [
            'label' => __('Title'),
            'sort' => 'title',
        ],
        [
            'label' => __('Type'),
            'sort' => 'openai_id',
        ],
        [
            'label' => __('Cost'),
            'sort' => 'credits',
        ],
    ];

    $filter_buttons = [
        [
            'label' => __('All'),
            'filter' => 'all',
        ],
        [
            'label' => __('Favorites'),
            'filter' => 'favorites',
        ],
        [
            'label' => __('Text'),
            'filter' => 'text',
        ],
        [
            'label' => __('Image'),
            'filter' => 'image',
        ],
        [
            'label' => __('Video'),
            'filter' => 'video',
        ],
        [
            'label' => __('Code'),
            'filter' => 'code',
        ],
    ];
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('My Documents'))
@section('titlebar_title')
    <span class="documents-page-title">
        {{ $currfolder?->name ? __("Folder: $currfolder?->name") : __('My Documents') }}
    </span>
@endsection

{{-- Filter list --}}
@if ($items && count($items) > 0)
    @section('titlebar_after')
        <div class="flex flex-wrap items-center justify-between gap-2 lg:flex-nowrap">
            @if (blank($currfolder))
                <div class="flex flex-wrap items-center gap-1">
                    <x-dropdown.dropdown
                        class="pe-3"
                        offsetY="1rem"
                    >
                        <x-slot:trigger
                            class="sort-trigger-btn whitespace-nowrap px-3 py-1.5 rounded-md border transition-all duration-200 text-xs font-medium"
                            variant="link"
                            size="xs"
                        >
                            <span class="flex items-center gap-2">
                                <span>{{ __('Sort by:') }}</span>
                                <x-tabler-arrows-sort class="size-4" />
                            </span>
                        </x-slot:trigger>

                        <x-slot:dropdown
                            class="overflow-hidden text-2xs font-medium"
                        >
                            <form
                                class="lqd-sort-list flex flex-col"
                                id="sort-form"
                                action="{{ route('dashboard.user.openai.documents.all', $currfolder?->id ? ['id' => $currfolder->id] : []) }}"
                                method="GET"
                                x-init
                                x-target="lqd-docs-container"
                            >
                                <input
                                    type="hidden"
                                    name="filter"
                                    :value="$store.documentsFilter.filter"
                                >
                                <input
                                    type="hidden"
                                    name="page"
                                    value="1"
                                >
                                <input
                                    type="hidden"
                                    name="sort"
                                    :value="$store.documentsFilter.sort"
                                >
                                <input
                                    type="hidden"
                                    name="sortAscDesc"
                                    :value="$store.documentsFilter.sortAscDesc"
                                >
                                @foreach ($sort_buttons as $button)
                                    <button
                                        type="button"
                                        class="group flex w-full items-center gap-1 px-3 py-2 hover:bg-foreground/5 [&.active]:bg-foreground/5 transition-all"
                                        x-bind:class="$store.documentsFilter.sort === '{{ $button['sort'] }}' ? 'active bg-foreground/10' : ''"
                                        @click="
                                            $store.documentsFilter.changeSort('{{ $button['sort'] }}');
                                            $store.documentsFilter.changePage('1');
                                            $nextTick(() => {
                                                document.getElementById('sort-form').requestSubmit();
                                            });
                                        "
                                    >
                                        <span class="flex-1 text-left">{{ $button['label'] }}</span>
                                        <x-tabler-caret-down-filled
                                            class="size-3 transition-all"
                                            x-bind:class="$store.documentsFilter.sort === '{{ $button['sort'] }}' ? ($store.documentsFilter.sortAscDesc === 'asc' ? 'opacity-100 rotate-180' : 'opacity-100') : 'opacity-0'"
                                        />
                                    </button>
                                @endforeach
                            </form>
                        </x-slot:dropdown>
                    </x-dropdown.dropdown>

                    <div class="lqd-filter-list-wrapper flex flex-wrap items-center gap-x-2 gap-y-2 max-sm:gap-2">
                        <span class="text-xs font-medium text-foreground/70 mr-1">Filters:</span>
                        <form
                            class="lqd-filter-list flex flex-wrap items-center gap-x-2 gap-y-2"
                            id="filter-form"
                            action="{{ route('dashboard.user.openai.documents.all', $currfolder?->id ? ['id' => $currfolder->id] : []) }}"
                            method="GET"
                            x-init
                            x-target="lqd-docs-container"
                        >
                            <input
                                type="hidden"
                                name="sort"
                                :value="$store.documentsFilter.sort"
                            >
                            <input
                                type="hidden"
                                name="page"
                                value="1"
                            >
                            <input
                                type="hidden"
                                name="sortAscDesc"
                                :value="$store.documentsFilter.sortAscDesc"
                            >
                            <input
                                type="hidden"
                                name="filter"
                                :value="$store.documentsFilter.filter"
                            >
                            @foreach ($filter_buttons as $button)
                                <button
                                    type="button"
                                    class="lqd-filter-btn inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 border"
                                    x-bind:class="$store.documentsFilter.filter === '{{ $button['filter'] }}' ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 border-cyan-500/50 text-cyan-300 shadow-lg shadow-cyan-500/20' : 'bg-foreground/5 border-foreground/10 text-foreground/70 hover:bg-foreground/10 hover:border-foreground/20 hover:text-foreground'"
                                    @click="
                                        $store.documentsFilter.changeFilter('{{ $button['filter'] }}');
                                        $store.documentsFilter.changePage('1');
                                        $nextTick(() => {
                                            document.getElementById('filter-form').requestSubmit();
                                        });
                                    "
                                >
                                    {{ $button['label'] }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                </div>

                <div class="lqd-posts-view-toggle lqd-docs-view-toggle lqd-view-toggle relative z-1 flex items-center gap-2 lg:ms-auto lg:justify-end">
                    <button
                        class="lqd-view-toggle-trigger inline-flex size-7 items-center justify-center rounded-md transition-colors hover:bg-foreground/5 [&.active]:bg-foreground/5"
                        :class="$store.docsViewMode.docsViewMode === 'list' && 'active'"
                        x-init
                        @click="$store.docsViewMode.change('list')"
                        title="List view"
                    >
                        <x-tabler-list
                            class="size-5"
                            stroke-width="1.5"
                        />
                    </button>
                    <button
                        class="lqd-view-toggle-trigger inline-flex size-7 items-center justify-center rounded-md transition-colors hover:bg-foreground/5 [&.active]:bg-foreground/5"
                        :class="$store.docsViewMode.docsViewMode === 'grid' && 'active'"
                        x-init
                        @click="$store.docsViewMode.change('grid')"
                        title="Grid view"
                    >
                        <x-tabler-layout-grid
                            class="size-5"
                            stroke-width="1.5"
                        />
                    </button>
                </div>
            @endif
        </div>
    @endsection
@endif

@push('css')
    <style>
        /* Documents Page Background - Matching Dashboard Theme */
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
        #rocket-stars-documents {
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
        .documents-page-title {
            display: inline-block;
            padding:7px;
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
        
        /* Improved Font Styling for Documents Page */
        .lqd-page-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }
        
        /* Better Typography for Headings */
        /* .lqd-titlebar-title {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        } */

        .lqd-titlebar-title {
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
        
        /* Improved Button and Filter Text */
        .lqd-filter-btn,
        .lqd-sort-list button,
        button[class*="lqd-"] {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        
        /* Better Table/List Text */
        .lqd-docs-container,
        .lqd-docs-container *,
        .lqd-docs-head,
        .lqd-docs-head span {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            font-weight: 500;
        }
        
        /* Document List Items */
        .lqd-posts-item,
        .lqd-docs-item,
        [class*="document-"] {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        
        /* Better readability for document names */
        .lqd-docs-container a,
        .lqd-docs-container span,
        .lqd-docs-container div {
            font-weight: 400;
            letter-spacing: 0.01em;
        }
        
        /* Table headers - more prominent */
        .lqd-docs-head {
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        
        /* Filter and sort buttons - better visibility */
        .lqd-filter-list,
        .lqd-sort-list {
            font-weight: 500;
        }
        
        /* Action buttons text */
        button small,
        .lqd-btn small {
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        
        /* Filter Buttons - Better Visibility */
        .lqd-filter-list-wrapper {
            position: relative;
        }
        
        .lqd-filter-btn {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        
        .lqd-filter-btn:hover {
            transform: translateY(-1px);
        }
        
        .lqd-filter-btn:active {
            transform: translateY(0);
        }
        
        /* Sort Dropdown - Better Styling */
        .lqd-sort-list button {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .lqd-sort-list button:hover {
            background-color: rgba(0, 212, 255, 0.1);
        }
        
        .lqd-sort-list button.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(123, 47, 247, 0.15));
            border-left: 3px solid rgba(0, 212, 255, 0.6);
        }
        
        /* Sort Dropdown Trigger - Better Visibility */
        .sort-trigger-btn {
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            background: rgba(0, 212, 255, 0.05) !important;
            color: rgba(0, 212, 255, 0.9) !important;
        }
        
        .sort-trigger-btn:hover {
            border-color: rgba(0, 212, 255, 0.5) !important;
            background: rgba(0, 212, 255, 0.1) !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 212, 255, 0.2);
        }
        
        /* Filter Label */
        .lqd-filter-list-wrapper > span {
            font-weight: 600;
            color: rgba(0, 212, 255, 0.8);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .documents-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .documents-page-title {
                font-size: 1.75rem;
            }
        }

        /* Unique Dropdown/Popup Background Styling - Same as Chatbot Agent */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content,
        .lqd-dropdown-dropdown-content {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(0, 212, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 0 40px rgba(0, 212, 255, 0.2),
                0 0 80px rgba(123, 47, 247, 0.15) !important;
        }

        /* Override any default background classes */
        body[data-theme="marketing-bot-dashboard"] .bg-dropdown-background,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content.bg-dropdown-background,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[class*="bg-"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
        }

        /* Force override for any gray/light backgrounds */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[style*="background"],
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content[style*="background-color"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
        }

        /* Dropdown items hover effect */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content a:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content li:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(123, 47, 247, 0.2) 100%) !important;
            border-left: 2px solid rgba(0, 212, 255, 0.7) !important;
            transition: all 0.3s ease;
        }

        /* Active dropdown item */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content a.active,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content [class*="active"] {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.25) 0%, rgba(123, 47, 247, 0.25) 100%) !important;
            border-left: 3px solid rgba(0, 212, 255, 0.9) !important;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.4) !important;
        }

        /* Dropdown text color */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content *,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content span,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content p {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Dropdown checkmark icon color */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content .text-primary,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content [class*="text-primary"] {
            color: rgba(0, 212, 255, 0.9) !important;
        }

        /* Dropdown list items spacing */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content ul {
            background: transparent !important;
        }

        /* Dropdown border styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content p[class*="border-b"] {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }

        /* Dropdown wrapper - ensure no gray background */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown {
            background: transparent !important;
        }

        /* Additional override for any nested elements with gray backgrounds */
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content > * {
            background: transparent !important;
        }

        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content ul,
        body[data-theme="marketing-bot-dashboard"] .lqd-dropdown-dropdown-content li {
            background: transparent !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-documents"></div>
    
    <div class="py-10 relative z-10">
        {{-- Folders row --}}
        @if ($currfolder == null)
            @if (isset(auth()->user()->folders) && count(auth()->user()->folders) > 0)
                <div class="mb-6 grid grid-cols-3 !gap-5 max-md:grid-cols-1">
                    @foreach (auth()->user()->folders ?? [] as $folder)
                        <x-documents.folder :$folder />
                    @endforeach
                </div>
            @endif
        @else
            <div class="mb-6 flex items-center gap-3">
                <x-button
                    class="aspect-square rounded-lg"
                    href="{{ route('dashboard.user.openai.documents.all') }}"
                    variant="secondary"
                    title="{{ __('Back to documents') }}"
                >
                    <x-tabler-arrow-left />
                </x-button>
                <x-documents.folder
                    :folder="$currfolder"
                    folder-single-view="{{ true }}"
                />
            </div>
        @endif

        {{-- Documents row --}}
        @if (!$items || count($items) === 0)
            @include('panel.user.openai.documents_empty')
        @else
            @include('panel.user.openai.documents_container')
                @endif

    </div>
@endsection

@push('script')
<script>
    // Helper function to submit documents filter/sort form
    function submitDocumentsForm(formId) {
        const form = document.getElementById(formId);
        if (!form) {
            console.error('Form not found:', formId);
            alert('Form not found. Please refresh the page.');
            return;
        }
        
        // Wait for Alpine to be ready
        if (typeof Alpine === 'undefined') {
            console.error('Alpine.js not loaded');
            alert('Page is still loading. Please wait a moment and try again.');
            return;
        }
        
        // Get current Alpine store values
        let store;
        try {
            store = Alpine.store('documentsFilter');
        } catch (e) {
            console.error('Error accessing Alpine store:', e);
            // Fallback to form values if store is not available
            const formData = new FormData(form);
            store = {
                sort: formData.get('sort') || 'created_at',
                sortAscDesc: formData.get('sortAscDesc') || 'desc',
                filter: formData.get('filter') || 'all'
            };
        }
        
        if (!store) {
            console.error('Alpine store documentsFilter not found, using form values');
            const formData = new FormData(form);
            store = {
                sort: formData.get('sort') || 'created_at',
                sortAscDesc: formData.get('sortAscDesc') || 'desc',
                filter: formData.get('filter') || 'all'
            };
        }
        
        const params = new URLSearchParams();
        
        // Use store values directly (they're the source of truth)
        params.set('sort', store.sort || 'created_at');
        params.set('sortAscDesc', store.sortAscDesc || 'desc');
        params.set('filter', store.filter || 'all');
        params.set('page', '1');
        params.set('listOnly', 'true');
        
        // Build the URL - use the form action as base
        let url = form.action;
        
        // Remove existing query params from action URL if any
        if (url.includes('?')) {
            url = url.split('?')[0];
        }
        
        // Fix protocol - ensure we use the same protocol as the current page
        if (url.startsWith('https://') && window.location.protocol === 'http:') {
            url = url.replace('https://', 'http://');
        } else if (url.startsWith('http://') && window.location.protocol === 'https:') {
            url = url.replace('http://', 'https://');
        }
        
        // Add query parameters
        const queryString = params.toString();
        const fullUrl = url + (queryString ? '?' + queryString : '');
        
        console.log('Fetching URL:', fullUrl);
        console.log('Parameters:', {
            sort: params.get('sort'),
            sortAscDesc: params.get('sortAscDesc'),
            filter: params.get('filter')
        });
        
        // Use a more reliable fetch with proper error handling
        fetch(fullUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
                'Cache-Control': 'no-cache'
            },
            credentials: 'same-origin',
            mode: 'same-origin'
        })
        .then(response => {
            console.log('Response status:', response.status, response.statusText);
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Response error HTML:', text.substring(0, 500));
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                });
            }
            return response.text();
        })
        .then(html => {
            if (!html || html.trim().length === 0) {
                throw new Error('Received empty response from server');
            }
            console.log('Received HTML length:', html.length);
            const container = document.getElementById('lqd-docs-container');
            if (container) {
                container.innerHTML = html;
                // Re-initialize any scripts in the new content
                if (window.Alpine) {
                    Alpine.initTree(container);
                }
            } else {
                console.error('Container lqd-docs-container not found');
                throw new Error('Document container not found on page');
            }
        })
        .catch(error => {
            console.error('Error loading documents:', error);
            console.error('Error details:', {
                message: error.message,
                stack: error.stack,
                url: fullUrl
            });
            alert('Error loading documents: ' + error.message + '\n\nPlease check the browser console (F12) for more details.');
        });
    }
    
    // Interactive Stars Background for Documents Page
    let documentsStars = [];
    let documentsMouseX = 0;
    let documentsMouseY = 0;
    
    function createDocumentsStars() {
        const starsContainer = document.getElementById('rocket-stars-documents');
        if (!starsContainer) return;
        
        const starCount = 100;
        documentsStars = [];
        
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
            documentsStars.push(star);
        }
        
        // Track mouse movement
        document.addEventListener('mousemove', function(e) {
            const starsContainer = document.getElementById('rocket-stars-documents');
            if (!starsContainer) return;
            
            const rect = starsContainer.getBoundingClientRect();
            documentsMouseX = ((e.clientX - rect.left) / rect.width) * 100;
            documentsMouseY = ((e.clientY - rect.top) / rect.height) * 100;
            
            updateDocumentsStars();
        });
        
        // Initialize stars
        updateDocumentsStars();
    }
    
    function updateDocumentsStars() {
        documentsStars.forEach(star => {
            const starX = parseFloat(star.dataset.x);
            const starY = parseFloat(star.dataset.y);
            
            // Calculate distance from mouse
            const dx = documentsMouseX - starX;
            const dy = documentsMouseY - starY;
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
        createDocumentsStars();
    });
    
    // Re-initialize if content is loaded dynamically
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', createDocumentsStars);
    } else {
        createDocumentsStars();
    }
</script>
@endpush

