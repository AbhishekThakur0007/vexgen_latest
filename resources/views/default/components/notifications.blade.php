@php
    $notifications = [];
    $unreadNotifications = auth()->user()->unreadNotifications;
    foreach ($unreadNotifications as $notification) {
        $notifications[] = [
            'title' => $notification->data['data']['title'],
            'message' => $notification->data['data']['message'],
            'link' => $notification->data['data']['link'],
            'unread' => true,
            'id' => $notification->id,
        ];
    }
    $trigger_class = @twMerge('commander-icon-button commander-icon-button--notification max-lg:size-10 max-lg:rounded-full max-lg:border max-lg:dark:bg-white/[3%]', $attributes->get('class:trigger'));
    $commanderBellGradient = uniqid('commander-bell-gradient-');
@endphp

<div
    {{ $attributes->withoutTwMergeClasses()->twMerge('notifications-wrap group hidden md:flex') }}
    x-data="notifications({{ json_encode($notifications) }})"
    x-init="$store.notifications.setNotifications(notifications)"
    :class="{ 'has-unread': $store.notifications.hasUnread() }"
>
    <x-dropdown.dropdown
        {{ $attributes->twMergeFor('dropdown', 'notifications-dropdown') }}
        anchor="end"
        offsetY="{{ $attributes->get('dropdown-offset-y') ?? '26px' }}"
    >
        <x-slot:trigger
            :class="$trigger_class"
            size="none"
        >
            <svg
                class="commander-icon commander-icon--notification ![animation-iteration-count:3] [transform-origin:50%_5px] group-[&.has-unread]:animate-bell-ring"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <defs>
                    <linearGradient id="{{ $commanderBellGradient }}" x1="5" y1="3" x2="19" y2="21" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#7b2ff7" />
                        <stop offset="55%" stop-color="#00d4ff" />
                        <stop offset="100%" stop-color="#00ff88" />
                    </linearGradient>
                </defs>
                <path
                    d="M12 21C13.1 21 14 20.1 14 19H10C10 20.1 10.9 21 12 21Z"
                    fill="url(#{{ $commanderBellGradient }})"
                    fill-opacity="0.8"
                />
                <path
                    d="M17.5 15C17.9 14.4 18 13.7 18 13V10.5C18 7.5 16.5 4.9 14 4.2C13.8 3.2 13 2.5 12 2.5C11 2.5 10.2 3.2 10 4.2C7.5 4.9 6 7.5 6 10.5V13C6 13.7 6.1 14.4 6.5 15L5 16.5V17.5H19V16.5L17.5 15Z"
                    stroke="url(#{{ $commanderBellGradient }})"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    fill="rgba(10, 18, 45, 0.55)"
            />
            </svg>
            <span
                class="commander-icon-badge hidden group-[&.has-unread]:inline-flex"
                x-show="$store.notifications.notifications.filter(notif => notif.unread).length"
                x-text="$store.notifications.notifications.filter(notif => notif.unread).length"
            ></span>
        </x-slot:trigger>

        <x-slot:dropdown
            class="max-h-96 w-80 overflow-y-auto"
        >
            <div
                class="relative"
                x-show="$store.notifications.notifications.length && $store.notifications.hasUnread()"
            >
                <h4 class="mb-0 flex items-center justify-between gap-2 border-b px-5 py-4 text-lg">
                    {{ trans('Notifications') }}
                    <x-button
                        class="rounded-lg bg-heading-foreground/[3%] px-3 py-1 text-2xs"
                        variant="ghost-shadow"
                        @click.prevent="$store.notifications.markAllAsRead()"
                    >
                        {{ trans('Mark All As Read') }}
                    </x-button>
                </h4>
                <ul class="notifications-list">
                    <template x-for="notification in $store.notifications.notifications.filter(notif => notif.unread)">
                        <li
                            class="header-notification-item group/item relative border-b px-5 py-4 transition-all last:border-b-0 hover:bg-heading-foreground/5"
                            :class="{ 'is-read': !notification.unread }"
                        >

                            <h5 class="relative mb-1">
                                <span x-text="notification.title"></span>
                                <span
                                    class="notifications-ping-wrap ms-2 inline-block size-2 rounded-full bg-red-500 align-super group-[&.is-read]/item:hidden"
                                    title="{{ __('Unread Notification') }}"
                                ></span>
                            </h5>
                            <p
                                class="mb-0 w-full overflow-hidden overflow-ellipsis whitespace-nowrap text-2xs opacity-55"
                                x-text="notification.message"
                            ></p>
                            <a
                                class="absolute inset-0 z-0 block"
                                href="#"
                                @click.prevent="$store.notifications.markThenHref(notification)"
                            ></a>
                        </li>
                    </template>
                </ul>
                <div
                    class="absolute inset-0 place-content-center bg-dropdown-background/10 backdrop-blur-sm"
                    :class="{ 'hidden': !$store.notifications.loading, 'grid': $store.notifications.loading }"
                >
                    <x-tabler-loader-2 class="size-9 animate-spin" />
                </div>
            </div>
            <h4
                class="px-4 py-10 text-center last:mb-0"
                x-show="!$store.notifications.notifications.length || !$store.notifications.hasUnread()"
            >
                {{ trans("There's No Notifications") }}
            </h4>
        </x-slot:dropdown>
    </x-dropdown.dropdown>
</div>
