{{-- XP Notification Container --}}
<div id="xp-notification-container" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none">
    {{-- Notifications will be dynamically inserted here --}}
</div>

<style>
    .xp-notification {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.95) 0%, rgba(123, 47, 247, 0.95) 100%);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 255, 136, 0.5);
        box-shadow: 0 10px 40px rgba(0, 212, 255, 0.3), 0 0 20px rgba(123, 47, 247, 0.2);
        animation: xpNotificationSlideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .xp-notification.exiting {
        animation: xpNotificationSlideOut 0.3s ease-in forwards;
    }

    @keyframes xpNotificationSlideIn {
        from {
            transform: translateX(400px) scale(0.8);
            opacity: 0;
        }
        to {
            transform: translateX(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes xpNotificationSlideOut {
        from {
            transform: translateX(0) scale(1);
            opacity: 1;
        }
        to {
            transform: translateX(400px) scale(0.8);
            opacity: 0;
        }
    }

    .xp-progress-bar {
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        overflow: hidden;
    }

    .xp-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #00ff88 0%, #00d4ff 100%);
        border-radius: 2px;
        transition: width 0.1s linear;
    }

    .xp-bounce {
        animation: xpBounce 0.6s ease;
    }

    @keyframes xpBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
</style>

<script>
(function() {
    'use strict';

    class XPNotificationSystem {
        constructor() {
            this.container = document.getElementById('xp-notification-container');
            this.activeNotifications = new Map();
            this.checkInterval = null;
            this.apiToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            this.apiBase = '/dashboard/user/xp';
            
            this.init();
        }

        init() {
            // Check for notifications on page load
            this.checkNotifications();
            
            // Poll for new notifications every 5 seconds
            this.checkInterval = setInterval(() => {
                this.checkNotifications();
            }, 5000);

            // Listen for generation completion events (if using custom events)
            document.addEventListener('generation-completed', (e) => {
                // Add a small delay to ensure XP is awarded by the observer
                setTimeout(() => {
                    this.checkNotifications();
                }, 500);
            });
        }

        async checkNotifications() {
            try {
                const response = await fetch(`${this.apiBase}/notifications`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) return;

                const data = await response.json();
                
                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(notification => {
                        if (!this.activeNotifications.has(notification.id)) {
                            this.showNotification(notification);
                        }
                    });
                }
            } catch (error) {
                console.error('Error checking XP notifications:', error);
            }
        }

        showNotification(notification) {
            const notificationId = notification.id;
            
            // Mark as shown immediately
            this.markAsShown(notificationId);

            // Create notification element
            const notificationEl = this.createNotificationElement(notification);
            this.container.appendChild(notificationEl);
            this.activeNotifications.set(notificationId, notificationEl);

            // Auto-dismiss after 5 seconds
            const progressBar = notificationEl.querySelector('.xp-progress-fill');
            let progress = 100;
            const progressInterval = setInterval(() => {
                progress -= 2; // Decrease by 2% every 100ms (5 seconds total)
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }
                if (progress <= 0) {
                    clearInterval(progressInterval);
                    this.dismissNotification(notificationId, false);
                }
            }, 100);

            // Store interval for cleanup
            notificationEl.dataset.progressInterval = progressInterval;
        }

        createNotificationElement(notification) {
            const el = document.createElement('div');
            el.className = 'xp-notification pointer-events-auto min-w-[320px] max-w-[400px] rounded-2xl p-5 text-white';
            el.dataset.notificationId = notification.id;
            el.dataset.sourceId = notification.source_id || '';

            const isGeneration = notification.source_type === 'generation';
            const icon = isGeneration ? '🎨' : '⭐';
            const actionText = isGeneration ? 'Wanna see your new generation?' : '';

            el.innerHTML = `
                <div class="flex items-start gap-4">
                    <div class="xp-icon text-4xl xp-bounce">${icon}</div>
                    <div class="flex-1">
                        <div class="font-bold text-lg mb-1">${notification.message || 'XP Earned!'}</div>
                        <div class="text-2xl font-bold text-[#00ff88] mb-2">+${notification.xp_amount} XP</div>
                        ${actionText ? `<div class="text-sm text-white/80 mb-3">${actionText}</div>` : ''}
                        ${isGeneration ? `
                            <div class="flex gap-2">
                                <button class="xp-view-btn bg-[#00ff88] hover:bg-[#00d4ff] text-black px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                                    Yes
                                </button>
                                <button class="xp-dismiss-btn bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                                    No
                                </button>
                            </div>
                        ` : ''}
                    </div>
                    <button class="xp-close-btn text-white/60 hover:text-white text-xl leading-none" aria-label="Close">
                        ×
                    </button>
                </div>
                <div class="xp-progress-bar mt-3">
                    <div class="xp-progress-fill" style="width: 100%;"></div>
                </div>
            `;

            // Add event listeners
            const viewBtn = el.querySelector('.xp-view-btn');
            const dismissBtn = el.querySelector('.xp-dismiss-btn');
            const closeBtn = el.querySelector('.xp-close-btn');

            if (viewBtn && isGeneration) {
                viewBtn.addEventListener('click', () => {
                    this.viewGeneration(notification.source_id);
                    this.dismissNotification(notification.id, true);
                });
            }

            if (dismissBtn) {
                dismissBtn.addEventListener('click', () => {
                    this.dismissNotification(notification.id, true);
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    this.dismissNotification(notification.id, true);
                });
            }

            // Click anywhere on notification to view (if generation)
            if (isGeneration) {
                el.addEventListener('click', (e) => {
                    if (!e.target.closest('button')) {
                        this.viewGeneration(notification.source_id);
                        this.dismissNotification(notification.id, true);
                    }
                });
            }

            return el;
        }

        async markAsShown(notificationId) {
            try {
                await fetch(`${this.apiBase}/notifications/shown`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': this.apiToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ xp_id: notificationId })
                });
            } catch (error) {
                console.error('Error marking notification as shown:', error);
            }
        }

        async dismissNotification(notificationId, userDismissed = false) {
            const notificationEl = this.activeNotifications.get(notificationId);
            if (!notificationEl) return;

            // Clear progress interval
            if (notificationEl.dataset.progressInterval) {
                clearInterval(parseInt(notificationEl.dataset.progressInterval));
            }

            // Mark as dismissed if user dismissed
            if (userDismissed) {
                try {
                    await fetch(`${this.apiBase}/notifications/dismissed`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': this.apiToken
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ xp_id: notificationId })
                    });
                } catch (error) {
                    console.error('Error dismissing notification:', error);
                }
            }

            // Animate out
            notificationEl.classList.add('exiting');
            setTimeout(() => {
                notificationEl.remove();
                this.activeNotifications.delete(notificationId);
            }, 300);
        }

        viewGeneration(generationId) {
            if (!generationId) return;
            
            // Navigate to generation view
            // Adjust route based on your application structure
            window.location.href = `/dashboard/user/openai/${generationId}`;
        }

        destroy() {
            if (this.checkInterval) {
                clearInterval(this.checkInterval);
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            window.xpNotificationSystem = new XPNotificationSystem();
        });
    } else {
        window.xpNotificationSystem = new XPNotificationSystem();
    }
})();
</script>

