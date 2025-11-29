@php
    use App\Domains\Entity\EntityStats;
    use App\Models\UserOpenai;
    use App\Services\XP\XPService;
    use Carbon\Carbon;
    
    $user = auth()->user();
    $setting = \App\Models\Setting::getCache();
    $firstName = $user?->name ? explode(' ', $user->name)[0] : 'Commander';
    $wordModels = EntityStats::word();
    $imageModels = EntityStats::image();
    $textToSpeechModels = EntityStats::textToSpeech();
    $textToVideoModels = EntityStats::textToVideo();
    
    $remainingWords = $wordModels->forUser($user)->totalCredits();
    $remainingImages = $imageModels->forUser($user)->totalCredits();
    $remainingVoice = $textToSpeechModels->forUser($user)->totalCredits();
    $remainingVideo = $textToVideoModels->forUser($user)->totalCredits();
    
    $plan = $user?->activePlan();
    $totalWords = $plan && isset($plan->ai_models['word']) ? $plan->ai_models['word'] : 10000;
    $totalImages = $plan && isset($plan->ai_models['image']) ? $plan->ai_models['image'] : 1000;
    
    $vexiumAmount = (int) $remainingWords;
    $totalVexium = (int) $totalWords;
    $fuelPercentage = $totalVexium > 0 ? min(100, max(0, ($vexiumAmount / $totalVexium) * 100)) : 0;
    
    // Calculate launches available based on individual credit types
    $textLaunches = floor($remainingWords / 10);
    $imageLaunches = floor($remainingImages / 50);
    $voiceLaunches = floor($remainingVoice / 25);
    $videoLaunches = floor($remainingVideo / 200);
    
    // Determine routes for launch buttons
    $textRoute = $setting->feature_ai_advanced_editor 
        ? LaravelLocalization::localizeUrl(route('dashboard.user.generator.index')) 
        : LaravelLocalization::localizeUrl(route('dashboard.user.openai.list'));
    $imageRoute = LaravelLocalization::localizeUrl(route('dashboard.user.openai.list'));
    $voiceRoute = LaravelLocalization::localizeUrl(route('dashboard.user.openai.list'));
    $videoRoute = LaravelLocalization::localizeUrl(route('dashboard.user.openai.list'));
    
    // Calculate This Month's Mission Log Data
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    
    // Get this month's usage data with optimized queries
    $thisMonthUsageQuery = UserOpenai::where('user_id', $user->id)
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->with('generator:id,type');
    
    // Calculate actual missions completed this month by type (optimized with joins)
    $thisMonthTextMissions = (clone $thisMonthUsageQuery)
        ->whereHas('generator', function($q) {
            $q->whereIn('type', ['text', 'code']);
        })
        ->count();
    
    $thisMonthImageMissions = (clone $thisMonthUsageQuery)
        ->whereHas('generator', function($q) {
            $q->where('type', 'image');
        })
        ->count();
    
    $thisMonthVoiceMissions = (clone $thisMonthUsageQuery)
        ->whereHas('generator', function($q) {
            $q->where('type', 'voice');
        })
        ->count();
    
    $thisMonthVideoMissions = (clone $thisMonthUsageQuery)
        ->whereHas('generator', function($q) {
            $q->where('type', 'video');
        })
        ->count();
    
    // Total missions this month
    $totalMissionsThisMonth = $thisMonthTextMissions + $thisMonthImageMissions + $thisMonthVoiceMissions + $thisMonthVideoMissions;
    
    // Calculate VEX consumed this month (sum of credits) - optimized query
    $vexConsumedThisMonth = (int) UserOpenai::where('user_id', $user->id)
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->sum('credits');
    
    // Calculate XP from UserXP table (actual XP system)
    $xpService = app(XPService::class);
    $currentXP = $xpService->getTotalXP($user);
    
    // XP level calculation (progressive levels)
    $xpLevels = [0, 1000, 2500, 5000, 10000, 25000, 50000, 100000];
    $currentLevel = 0;
    $nextLevelXP = 1000;
    
    for ($i = count($xpLevels) - 1; $i >= 0; $i--) {
        if ($currentXP >= $xpLevels[$i]) {
            $currentLevel = $i;
            $nextLevelXP = $xpLevels[$i + 1] ?? $xpLevels[$i] * 2;
            break;
        }
    }
    
    $xpPercentage = $nextLevelXP > 0 ? min(100, max(0, ($currentXP / $nextLevelXP) * 100)) : 0;
    $xpNeeded = max(0, $nextLevelXP - $currentXP);
    
    // Mission day calculation (days since registration)
    $missionDay = $user?->created_at ? $user->created_at->diffInDays(now()) + 1 : 1;
    
    // Status determination
    if ($fuelPercentage >= 75) {
        $status = 'OPTIMAL FLIGHT RANGE';
        $statusColor = '#00ff88';
    } elseif ($fuelPercentage >= 50) {
        $status = 'GOOD FUEL LEVEL';
        $statusColor = '#00d4ff';
    } elseif ($fuelPercentage >= 25) {
        $status = 'REFUEL RECOMMENDED';
        $statusColor = '#ffd700';
    } else {
        $status = 'REFUEL REQUIRED';
        $statusColor = '#ff3366';
    }
@endphp

{{-- Animated Stars Background --}}
<div class="rocket-stars-background" id="rocket-stars"></div>

{{-- Commander Hero Card --}}
<div class="commander-card col-span-full mb-8">
    <div class="commander-content grid grid-cols-1 lg:grid-cols-3 gap-10 items-center relative z-10">
        <div class="commander-left lg:col-span-2">
            <h1 class="commander-title">Welcome Back, Commander!</h1>
            <div class="commander-subtitle text-gray-400 text-xl mb-6">
                {{ $firstName }} | Mission Day #{{ $missionDay }}
            </div>
            
            <div class="xp-section mt-5">
                <div class="xp-header flex justify-between mb-3">
                    <span class="xp-label text-[#00d4ff] text-lg">Experience Points</span>
                    <span class="xp-value text-white text-lg font-semibold"><span class="xp-current-value">{{ number_format($currentXP) }}</span> / <span class="xp-max-value">{{ number_format($nextLevelXP) }}</span> XP</span>
                </div>
                <div class="xp-bar-container">
                    <div class="xp-bar">
                        <div class="xp-fill" style="width: {{ $xpPercentage }}%;" data-width="{{ $xpPercentage }}%">
                            <div class="xp-rocket-indicator">🚀</div>
                            <span class="xp-percentage-text">{{ number_format($xpPercentage, 0) }}%</span>
                        </div>
                    </div>
                </div>
                <div class="next-rank mt-3 text-gray-400 text-sm">
                    <span class="text-[#00ff88] font-semibold xp-needed-value">{{ number_format($xpNeeded) }}</span> XP until <span class="text-[#00ff88] font-semibold">Captain Rank</span>
                </div>
            </div>
        </div>
        
        <div class="rocketship-display text-center">
            <div class="rocket-3d">🚀</div>
            <div class="rocket-status">⚡ MISSION READY</div>
            <div class="streak-counter flex items-center justify-center gap-3 mt-4 p-3 bg-orange-500/20 rounded-2xl border-2 border-orange-500">
                <span class="streak-fire text-2xl animate-pulse">🔥</span>
                <span class="font-bold">{{ $missionDay }} DAY Launch Streak!</span>
            </div>
        </div>
    </div>
</div>

{{-- Search Anything Bar --}}
@include('marketing-bot-dashboard.panel.user.dashboard.search-anything')

{{-- Fuel Tank & Discount Section --}}
<div class="fuel-tank-section grid grid-cols-1 lg:grid-cols-2 gap-6 col-span-full mb-8 items-start">
    {{-- Vexium Fuel Tank --}}
    @include('marketing-bot-dashboard.components.vexium-fuel-tank')
    
    {{-- Discount Unlock Card with Video --}}
    <div class="discount-card">
        <div class="discount-video-container">
            <video 
                class="discount-video"
                autoplay
                loop
                muted
                playsinline
                preload="auto"
            >
                <source src="https://cdn.prod.website-files.com/689597cc2d57ee623f5a24a2%2F689c3850b8428d2531672b1f_hero-transcode.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

{{-- Launch Capabilities --}}
<h2 class="capabilities-title text-3xl font-bold mb-6 text-center col-span-full bg-gradient-to-r from-[#00d4ff] to-[#7b2ff7] bg-clip-text text-transparent">
    🎯 Launch Systems Ready
</h2>

<div class="capabilities-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 col-span-full mb-8">
    <div class="capability-card">
        <div class="capability-icon">🤖</div>
        <div class="capability-name text-xl font-bold mb-2">Text Generator</div>
        <div class="capability-cost text-gray-400 mb-5">10 VEX per launch</div>
        <div class="launches-display bg-black/30 p-4 rounded-2xl mb-4">
            <div class="launches-number text-4xl font-bold text-[#00ff88] mb-2" data-count="{{ $textLaunches }}">0</div>
            <div class="launches-label text-sm text-gray-400">launches ready</div>
        </div>
        <a href="{{ $textRoute }}" class="launch-btn w-full inline-block text-center">🚀 Launch Now</a>
    </div>
    
    <div class="capability-card">
        <div class="capability-icon">🎨</div>
        <div class="capability-name text-xl font-bold mb-2">Image Creator</div>
        <div class="capability-cost text-gray-400 mb-5">50 VEX per launch</div>
        <div class="launches-display bg-black/30 p-4 rounded-2xl mb-4">
            <div class="launches-number text-4xl font-bold text-[#00ff88] mb-2" data-count="{{ $imageLaunches }}">0</div>
            <div class="launches-label text-sm text-gray-400">launches ready</div>
        </div>
        <a href="{{ $imageRoute }}" class="launch-btn w-full inline-block text-center">🚀 Launch Now</a>
    </div>
    
    <div class="capability-card">
        <div class="capability-icon">🎙️</div>
        <div class="capability-name text-xl font-bold mb-2">Voice Synthesis</div>
        <div class="capability-cost text-gray-400 mb-5">25 VEX per launch</div>
        <div class="launches-display bg-black/30 p-4 rounded-2xl mb-4">
            <div class="launches-number text-4xl font-bold text-[#00ff88] mb-2" data-count="{{ $voiceLaunches }}">0</div>
            <div class="launches-label text-sm text-gray-400">launches ready</div>
        </div>
        <a href="{{ $voiceRoute }}" class="launch-btn w-full inline-block text-center">🚀 Launch Now</a>
    </div>
    
    <div class="capability-card">
        <div class="capability-icon">🎬</div>
        <div class="capability-name text-xl font-bold mb-2">Video Generator</div>
        <div class="capability-cost text-gray-400 mb-5">200 VEX per launch</div>
        <div class="launches-display bg-black/30 p-4 rounded-2xl mb-4">
            <div class="launches-number text-4xl font-bold text-[#00ff88] mb-2" data-count="{{ $videoLaunches }}">0</div>
            <div class="launches-label text-sm text-gray-400">launches ready</div>
        </div>
        <a href="{{ $videoRoute }}" class="launch-btn w-full inline-block text-center">🚀 Launch Now</a>
    </div>
</div>

{{-- Mission Log Stats --}}
<div class="mission-log col-span-full mb-8">
    <h2 class="section-title text-3xl font-bold mb-6 bg-gradient-to-r from-[#00d4ff] to-[#7b2ff7] bg-clip-text text-transparent">
        📊 This Month's Mission Log
    </h2>
    
    <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="stat-box" data-animate="true">
            <div class="stat-icon text-4xl mb-3">🎯</div>
            <div class="stat-value" data-count="{{ $totalMissionsThisMonth }}">0</div>
            <div class="stat-label text-gray-400 text-sm">Total Missions</div>
            <div class="stat-breakdown text-xs text-gray-500 mt-1">
                🤖 {{ $thisMonthTextMissions }} • 🎨 {{ $thisMonthImageMissions }} • 🎙️ {{ $thisMonthVoiceMissions }} • 🎬 {{ $thisMonthVideoMissions }}
            </div>
        </div>
        
        <div class="stat-box" data-animate="true">
            <div class="stat-icon text-4xl mb-3">⚡</div>
            <div class="stat-value" data-count="{{ $vexConsumedThisMonth }}">0</div>
            <div class="stat-label text-gray-400 text-sm">VEX Consumed</div>
            <div class="stat-breakdown text-xs text-gray-500 mt-1">
                {{ __('This month') }}
            </div>
        </div>
        
        <div class="stat-box" data-animate="true">
            <div class="stat-icon text-4xl mb-3">🔥</div>
            <div class="stat-value" data-count="{{ $missionDay }}">0</div>
            <div class="stat-label text-gray-400 text-sm">Day Streak</div>
            <div class="stat-breakdown text-xs text-gray-500 mt-1">
                {{ __('Since registration') }}
            </div>
        </div>
        
        <div class="stat-box" data-animate="true">
            <div class="stat-icon text-4xl mb-3">⭐</div>
            <div class="stat-value" data-count="{{ $currentXP }}">0</div>
            <div class="stat-label text-gray-400 text-sm">XP Earned</div>
            <div class="stat-breakdown text-xs text-gray-500 mt-1">
                {{ number_format($xpNeeded) }} {{ __('to next level') }}
            </div>
        </div>
    </div>
</div>

{{-- Refuel CTA --}}
<div class="refuel-cta col-span-full mb-8 relative z-10">
    <h2 class="refuel-title text-4xl font-bold mb-4 text-white">Ready to Refuel Your Rocket?</h2>
    <p class="refuel-subtitle text-xl mb-6 text-white/90">Your achievements have unlocked special pricing!</p>
    <div class="refuel-discount-badge inline-block bg-[#ffd700] text-black px-10 py-4 rounded-full text-2xl font-bold mb-6 shadow-lg">
        🎉 YOU SAVE 15% ON NEXT REFUEL
    </div>
    <a href="{{ route('dashboard.user.payment.subscription') }}" class="refuel-btn inline-block">
        ⚡ Refuel Now →
    </a>
</div>

<script>
    // Interactive Dashboard Stars with Mouse Movement
    let dashboardStars = [];
    let dashboardMouseX = 0;
    let dashboardMouseY = 0;
    
    function createStars() {
        const starsContainer = document.getElementById('rocket-stars');
        if (!starsContainer) return;
        
        const starCount = 100;
        dashboardStars = [];
        
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
            dashboardStars.push(star);
        }
        
        // Track mouse movement on dashboard
        document.addEventListener('mousemove', function(e) {
            const starsContainer = document.getElementById('rocket-stars');
            if (!starsContainer) return;
            
            const rect = starsContainer.getBoundingClientRect();
            dashboardMouseX = ((e.clientX - rect.left) / rect.width) * 100;
            dashboardMouseY = ((e.clientY - rect.top) / rect.height) * 100;
            
            updateDashboardStars();
        });
        
        // Initialize stars
        updateDashboardStars();
    }
    
    function updateDashboardStars() {
        dashboardStars.forEach(star => {
            const starX = parseFloat(star.dataset.x);
            const starY = parseFloat(star.dataset.y);
            
            // Calculate distance from mouse
            const dx = dashboardMouseX - starX;
            const dy = dashboardMouseY - starY;
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
            
            // Add slight movement towards mouse
            const moveX = dx * 0.15;
            const moveY = dy * 0.15;
            star.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });
    }
    
    // Animate progress bars on load
    function animateProgressBars() {
        const progressBars = document.querySelectorAll('.xp-fill, .gauge-fill, .progress-fill');
        progressBars.forEach(bar => {
            const targetWidth = bar.style.width || bar.getAttribute('data-width') || '0%';
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 100);
        });
    }
    
    // Animate number counters
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }
    
    // Animate launch counters
    function animateLaunchCounters() {
        const launchNumbers = document.querySelectorAll('.launches-number[data-count]');
        launchNumbers.forEach(el => {
            const target = parseInt(el.getAttribute('data-count')) || 0;
            animateCounter(el, target, 1500);
        });
    }
    
    // Animate stat counters
    function animateStatCounters() {
        const statValues = document.querySelectorAll('.stat-value[data-count]');
        statValues.forEach((el, index) => {
            const target = parseInt(el.getAttribute('data-count')) || 0;
            setTimeout(() => {
                animateCounter(el, target, 2000);
            }, index * 200);
        });
    }
    
    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            animateProgressBars();
            setTimeout(() => {
                animateLaunchCounters();
                animateStatCounters();
            }, 300);
        });
    } else {
        createStars();
        animateProgressBars();
        setTimeout(() => {
            animateLaunchCounters();
            animateStatCounters();
        }, 300);
    }
</script>


