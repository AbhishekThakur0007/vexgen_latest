@php($commanderAgentGradient = uniqid('commander-agent-gradient-'))

<x-button
    {{ $attributes->twMerge('commander-icon-button commander-icon-button--inbox max-lg:hidden max-lg:size-10 max-lg:rounded-full max-lg:border max-lg:dark:bg-white/[3%] relative flex items-center justify-center') }}
    size="none"
    href="{{ route('dashboard.chatbot-agent.index') }}"
    title="{{ __('Human Agent') }}"
    variant="link"
    x-data="{}"
>
    <span
        class="commander-icon-badge hidden"
        id="inbox-notification-chatbot-agent"
    >0</span>
    <svg
        class="commander-icon commander-icon--inbox"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="{{ $commanderAgentGradient }}" x1="4" y1="6" x2="20" y2="19" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#7b2ff7" />
                <stop offset="55%" stop-color="#00d4ff" />
                <stop offset="100%" stop-color="#00ff88" />
            </linearGradient>
        </defs>
        <path
            d="M4.8 7.2L11.4 12.2C11.8 12.5 12.3 12.5 12.7 12.2L19.3 7.2"
            stroke="url(#{{ $commanderAgentGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <path
            d="M6 6H18C19.4 6 20.5 7.1 20.5 8.5V15.5C20.5 16.9 19.4 18 18 18H6C4.6 18 3.5 16.9 3.5 15.5V8.5C3.5 7.1 4.6 6 6 6Z"
            stroke="url(#{{ $commanderAgentGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
            fill="rgba(10, 18, 45, 0.55)"
        />
        <path
            d="M7.8 14.5H10.2C10.6 15.6 11.6 16.4 12.9 16.4C14.2 16.4 15.2 15.6 15.6 14.5H18"
            stroke="url(#{{ $commanderAgentGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
    />
    </svg>
</x-button>

@push('script')
    @if (config('chatbot.notification_enabled', true))
        <script>
            $(document).ready(function() {
                // Function to fetch the notification count
                function fetchNotificationCount() {
                    $.ajax({
                        url: '{{ route('dashboard.chatbot-agent.notification.count') }}',
                        type: 'GET',
                        success: function(data) {
                            let inboxNotification = $('#inbox-notification-chatbot-agent');

                            if (data.count > 0) {
                                inboxNotification.text(data.count);
                                inboxNotification.removeClass('hidden')
                            } else {
                                inboxNotification.addClass('hidden')
                            }
                        },
                        error: function() {
                            console.error('Error fetching notification count');
                        }
                    });
                }

                // Fetch the notification count on page load
                fetchNotificationCount();

                // Optionally, you can set an interval to refresh the count periodically
                setInterval(fetchNotificationCount, 3000); // Refresh every minute
            });
        </script>
    @endif
@endpush
