@php
    use App\Domains\Entity\EntityStats;
    $user = auth()->user();
    $remainingCredits = $user ? EntityStats::word()->forUser($user)->totalCredits() : 0;
    $plan = $user?->activePlan();
    $totalCredits = $plan && isset($plan->ai_models['word']) ? $plan->ai_models['word'] : 10000;
    $fuelPercentage = $totalCredits > 0 ? min(100, max(0, ($remainingCredits / $totalCredits) * 100)) : 0;
@endphp

<a
    {{ $attributes->class(['rocket-logo group relative flex shrink-0 items-center justify-center gap-3 transition-all hover:scale-105']) }}
    href="{{ route('dashboard.index') }}"
    x-data="{ showDropdown: false }"
    @mouseenter="showDropdown = true"
    @mouseleave="showDropdown = false"
>
    {{-- Rocket Icon --}}
    <div class="rocket-icon-container relative">
        <div class="rocket-icon text-4xl transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110">
            🚀
        </div>
        {{-- Fuel Indicator --}}
        <div class="absolute -bottom-1 left-1/2 h-1 w-16 -translate-x-1/2 rounded-full bg-black/30">
            <div 
                class="h-full rounded-full transition-all duration-500"
                style="width: {{ $fuelPercentage }}%; background: linear-gradient(90deg, #7b2ff7, #00d4ff, #00ff88);"
            ></div>
        </div>
    </div>
    
    {{-- Logo Text --}}
    <span class="rocket-logo-text text-xl font-bold bg-gradient-to-r from-[#00d4ff] to-[#7b2ff7] bg-clip-text text-transparent">
        VexGenAI
    </span>

    {{-- User Menu Dropdown on Hover --}}
    <!-- <div 
        x-show="showDropdown"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-x-2 lg:translate-x-2 lg:translate-y-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-x-0 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0 translate-y-0"
        x-transition:leave-end="opacity-0 translate-x-2 lg:translate-x-2 lg:translate-y-0 translate-y-2"
        class="absolute top-full left-0 mt-2 lg:top-0 lg:left-auto lg:right-full lg:mt-0 lg:mr-2 w-64 rounded-2xl bg-black/80 backdrop-blur-xl border border-purple-500/30 p-4 shadow-2xl z-50"
        style="display: none;"
    >
        <div class="space-y-3">
            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                <div class="text-2xl">👨‍🚀</div>
                <div>
                    <div class="text-sm font-semibold text-white">
                        {{ $user?->name ? explode(' ', $user->name)[0] : 'Commander' }}
                    </div>
                    <div class="text-xs text-gray-400">Commander Level 8</div>
                </div>
            </div>
            
            <div class="space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-300">Vexium Fuel:</span>
                    <span class="font-bold text-[#00ff88]">{{ number_format($remainingCredits) }} VEX</span>
                </div>
                <div class="h-2 w-full rounded-full bg-black/40 overflow-hidden">
                    <div 
                        class="h-full rounded-full transition-all duration-500"
                        style="width: {{ $fuelPercentage }}%; background: linear-gradient(90deg, #7b2ff7, #00d4ff, #00ff88);"
                    ></div>
                </div>
                <div class="text-xs text-gray-400 text-center">
                    {{ number_format($fuelPercentage, 1) }}% Remaining
                </div>
            </div>
        </div>
    </div> -->
</a>

