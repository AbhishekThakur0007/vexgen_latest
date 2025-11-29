@php($commanderInboxGradient = uniqid('commander-inbox-gradient-'))

<x-button
    class="commander-icon-button commander-icon-button--inbox relative flex items-center justify-center max-lg:hidden max-lg:size-10 max-lg:rounded-full max-lg:border max-lg:dark:bg-white/[3%]"
    size="none"
    href="{{ route('dashboard.user.marketing-bot.inbox.index') }}"
    title="{{ __('Marketing Inbox') }}"
    variant="link"
    x-data="{}"
>
    <span
        class="commander-icon-badge hidden"
        id="inbox-notification"
    >0</span>
    <svg
        class="commander-icon commander-icon--inbox"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="{{ $commanderInboxGradient }}" x1="3" y1="5" x2="21" y2="20" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#7b2ff7" />
                <stop offset="55%" stop-color="#00d4ff" />
                <stop offset="100%" stop-color="#00ff88" />
            </linearGradient>
        </defs>
        <path
            d="M4.5 7.5L11.2 12.4C11.7 12.7 12.3 12.7 12.8 12.4L19.5 7.5"
            stroke="url(#{{ $commanderInboxGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <path
            d="M5.5 6H18.5C19.9 6 21 7.1 21 8.5V15.5C21 16.9 19.9 18 18.5 18H5.5C4.1 18 3 16.9 3 15.5V8.5C3 7.1 4.1 6 5.5 6Z"
            stroke="url(#{{ $commanderInboxGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
            fill="rgba(10, 18, 45, 0.55)"
        />
        <path
            d="M7.5 14.5H10.2C10.6 15.6 11.7 16.4 13 16.4C14.3 16.4 15.4 15.6 15.8 14.5H18.5"
            stroke="url(#{{ $commanderInboxGradient }})"
            stroke-width="1.6"
            stroke-linecap="round"
    />
    </svg>
</x-button>

@push('script')
    @if (config('marketing-bot.notification_enabled', true))
        <script>
            $(document).ready(function() {
                // Function to fetch the notification count
                function fetchNotificationCount() {
                    $.ajax({
                        url: '{{ route('dashboard.user.marketing-bot.inbox.notification.count') }}',
                        type: 'GET',
                        success: function(data) {
                            let inboxNotification = $('#inbox-notification');

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
                // fetchNotificationCount();

                // Optionally, you can set an interval to refresh the count periodically
                setInterval(fetchNotificationCount, 10000); // Refresh every minute
            });
        </script>
    @endif
@endpush
