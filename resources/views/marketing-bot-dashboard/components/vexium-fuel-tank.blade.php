@php
    use App\Domains\Entity\EntityStats;
    use Illuminate\Support\Str;

    $user = auth()->user();
    $plan = $user?->activePlan();
    $entityStats = EntityStats::all();

    $rawBreakdown = [];
    $totalRemainingCredits = 0;
    $totalCapacityCredits = 0;
    $hasUnlimitedCategory = false;

    foreach ($entityStats as $statItem) {
        $userStat = (clone $statItem)->forUser($user);
        $planStat = $plan ? (clone $statItem)->forPlan($plan) : null;
        $drivers = $userStat->list();

        if ($drivers->isEmpty()) {
            continue;
        }

        $label = $drivers->first()->enum()->subLabel() ?? __('Mission Credits');
        $remaining = (float) $userStat->totalCredits();
        $capacity = (float) ($planStat ? $planStat->totalCredits() : $remaining);
        $isUnlimited = $userStat->checkIfThereUnlimited();

        if ($remaining <= 0 && ! $isUnlimited) {
            continue;
        }

        if (! isset($rawBreakdown[$label])) {
            $rawBreakdown[$label] = [
                'label'        => $label,
                'remaining'    => 0,
                'capacity'     => 0,
                'is_unlimited' => false,
            ];
        }

        $rawBreakdown[$label]['remaining'] += $remaining;

        if (! $rawBreakdown[$label]['is_unlimited'] && $isUnlimited) {
            $rawBreakdown[$label]['is_unlimited'] = true;
        }

        if (! $isUnlimited) {
            $rawBreakdown[$label]['capacity'] += $capacity;
        }
    }

    $creditBreakdown = collect($rawBreakdown)->map(function (array $item) use (&$totalRemainingCredits, &$totalCapacityCredits, &$hasUnlimitedCategory) {
        $remaining = (float) $item['remaining'];
        $capacity = (float) $item['capacity'];
        $isUnlimited = (bool) $item['is_unlimited'];

        $totalRemainingCredits += $remaining;

        if ($isUnlimited) {
            $hasUnlimitedCategory = true;
            $computedCapacity = max($remaining, 1);
            $percentage = 100;
        } else {
            $computedCapacity = max($capacity, 0);
            $totalCapacityCredits += $computedCapacity;
            $percentage = $computedCapacity > 0 ? min(100, max(0, ($remaining / $computedCapacity) * 100)) : 0;
        }

        $item['capacity'] = $computedCapacity;
        $item['percentage'] = round($percentage, 1);

        return $item;
    })->sortByDesc('remaining')->values();

    if ($hasUnlimitedCategory) {
        $totalCapacityCredits = max($totalCapacityCredits, $totalRemainingCredits);
    }

    $vexiumAmount = (int) round($totalRemainingCredits);
    $totalVexium = (int) max(round($totalCapacityCredits), 1);
    $fuelPercentage = $totalVexium > 0 ? min(100, max(0, ($vexiumAmount / max($totalVexium, 1)) * 100)) : 0;

    if ($hasUnlimitedCategory) {
        $fuelPercentage = 100;
    }

    $determineStatus = function ($percentage) use ($hasUnlimitedCategory) {
        if ($hasUnlimitedCategory || $percentage >= 100) {
            return ['LIMITLESS THRUST', '#7bffbf'];
        }

        if ($percentage >= 75) {
            return ['OPTIMAL FLIGHT RANGE', '#00ff88'];
        }

        if ($percentage >= 50) {
            return ['GOOD FUEL LEVEL', '#00d4ff'];
        }

        if ($percentage >= 25) {
            return ['REFUEL RECOMMENDED', '#ffd700'];
        }

        return ['REFUEL REQUIRED', '#ff3366'];
    };

    [$status, $statusColor] = $determineStatus($fuelPercentage);
    $categoriesCount = $creditBreakdown->count();
@endphp

<div
    x-data="{ showBreakdown: false, showTooltip: false }"
    class="fuel-tank-card"
>
    <div class="fuel-header flex justify-between items-center mb-6">
        <div>
            <div class="fuel-title text-2xl font-bold">💎 Vexium Fuel Tank</div>
        </div>
        <div class="fuel-icon-large text-4xl">⚡</div>
    </div>
    
    <div class="vexium-display text-center my-8">
        <div class="vexium-amount">{{ number_format($vexiumAmount) }}</div>
        <div class="vexium-label text-gray-400 text-lg">{{ __('Combined Mission Fuel') }}</div>
        <div class="vexium-subtext text-gray-500 text-xs mt-2">
            {{ number_format($categoriesCount) }} {{ Str::plural(__('credit system'), $categoriesCount) }} {{ __('calibrated') }}
        </div>
    </div>
    
    <div class="fuel-gauge-3d">
        <div class="gauge-bar">
            <div class="gauge-fill" style="width: {{ $fuelPercentage }}%;">{{ number_format($fuelPercentage, 1) }}%</div>
        </div>
        <div class="gauge-labels flex justify-between mt-4 text-gray-400 text-sm">
            <span>0 VEX</span>
            <span>{{ number_format($totalVexium) }} VEX</span>
        </div>
    </div>
    
    <div class="flex items-center justify-between gap-6 mt-8">
        <div class="fuel-status" style="border-color: {{ $statusColor }}; background: rgba({{ hexdec(substr($statusColor, 1, 2)) }}, {{ hexdec(substr($statusColor, 3, 2)) }}, {{ hexdec(substr($statusColor, 5, 2)) }}, 0.1);">
            <div class="status-dot-large" style="background: {{ $statusColor }};"></div>
            <strong style="color: {{ $statusColor }};">{{ $status }}</strong>
        </div>

        <button
            type="button"
            class="vexium-alien-button"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false"
            @click="showBreakdown = !showBreakdown"
            :aria-expanded="showBreakdown.toString()"
        >
            <span class="vexium-alien-emoji" aria-hidden="true">👽</span>
            <span
                class="vexium-alien-tooltip"
                x-cloak
                x-show="showTooltip"
                x-transition
            >
                {{ __('Click me for in-depth details') }}
            </span>
            <span class="sr-only">{{ __('Toggle mission credit breakdown') }}</span>
        </button>
    </div>

    <div
        class="vexium-breakdown-panel"
        x-cloak
        x-show="showBreakdown"
        x-transition
    >
        <div class="vexium-breakdown-header">
            <div>
                <h3 class="vexium-breakdown-title">{{ __('Mission Credit Breakdown') }}</h3>
                <p class="vexium-breakdown-subtitle">
                    {{ __('Live telemetry across words, images, audio, video, and more.') }}
                </p>
            </div>
            <button
                type="button"
                class="vexium-breakdown-close"
                @click="showBreakdown = false"
            >
                ×
                <span class="sr-only">{{ __('Close breakdown panel') }}</span>
            </button>
        </div>

        @if ($creditBreakdown->isNotEmpty())
            <ul class="vexium-breakdown-list">
                @foreach ($creditBreakdown as $item)
                    <li class="vexium-breakdown-item">
                        <div class="vexium-breakdown-row">
                            <span class="vexium-breakdown-label">{{ $item['label'] }}</span>
                            <span class="vexium-breakdown-remaining">
                                <span>{{ $item['is_unlimited'] ? __('Unlimited') : number_format($item['remaining']) }}</span>
                                <span class="vexium-breakdown-unit">{{ __('Remaining') }}</span>
                            </span>
                        </div>

                        @if ($item['is_unlimited'])
                            <div class="vexium-breakdown-cap">
                                <span>{{ __('Limitless capacity engaged') }}</span>
                            </div>
                        @else
                            <div class="vexium-breakdown-cap">
                                <span>{{ __('Capacity') }}: {{ number_format($item['capacity']) }}</span>
                                <span>{{ number_format($item['percentage'], 1) }}%</span>
                            </div>
                            <div class="vexium-breakdown-bar">
                                <div
                                    class="vexium-breakdown-bar-fill"
                                    style="width: {{ $item['percentage'] }}%;"
                                ></div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="vexium-breakdown-empty">
                {{ __('No additional credit systems detected. Launch new missions to unlock more fuel data!') }}
            </p>
        @endif
    </div>
</div>
