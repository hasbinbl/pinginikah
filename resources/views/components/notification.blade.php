@props(['mobile' => false])

@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $notifications = auth()->user()->notifications;
@endphp

@if ($mobile)
    <div class="pt-4 pb-2 border-t border-accent">
        <div class="px-4 flex items-center justify-between mb-2">
            <div class="font-medium text-base text-light">Notifikasi</div>
            @if ($unreadCount > 0)
                <a href="{{ route('notifications.markRead') }}" class="text-xs text-light font-semibold hover:underline">
                    Tandai semua dibaca
                </a>
            @endif
        </div>

        <div class="space-y-1">
            @forelse($notifications->take(5) as $notification)
                <x-responsive-nav-link :href="$notification->data['url'] ?? '#'"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ $notification->read_at ? 'border-transparent text-accent' : 'border-accent text-primary bg-light' }}">
                    <div class="flex flex-col">
                        <span class="font-semibold text-sm">{{ $notification->data['title'] ?? 'Info' }}</span>
                        <span
                            class="text-xs font-normal text-gray-500 line-clamp-1">{{ $notification->data['message'] ?? '' }}</span>
                        <span
                            class="text-[10px] text-accent mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </x-responsive-nav-link>
            @empty
                <div class="px-4 py-2 text-sm text-accent">Tidak ada notifikasi baru.</div>
            @endforelse
        </div>
    </div>
@else
    <div class="relative mr-4" x-data="{ open: false }">
        <button @click="open = !open"
            class="relative p-2 rounded-full text-light hover:bg-light hover:text-primary focus:outline-none transition">
            <span class="sr-only">View notifications</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            @if ($unreadCount > 0)
                <span
                    class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-dark animate-pulse"></span>
            @endif
        </button>

        <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5 origin-top-right"
            style="display: none;">

            <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Notifikasi</span>
                @if ($unreadCount > 0)
                    <a href="{{ route('notifications.markRead') }}"
                        class="text-xs text-primary font-semibold hover:underline">
                        Tandai dibaca
                    </a>
                @endif
            </div>

            <div class="max-h-80 overflow-y-auto">
                @forelse($notifications as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}"
                        class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 last:border-0 {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/40' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                @if (isset($notification->data['type']) && $notification->data['type'] == 'invitation')
                                    <div
                                        class="h-8 w-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center">
                                        💍</div>
                                @else
                                    <div
                                        class="h-8 w-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center">
                                        ℹ️</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $notification->data['title'] ?? 'Info' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">
                                    {{ $notification->data['message'] ?? '' }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if (!$notification->read_at)
                                <div class="mt-2 h-2 w-2 rounded-full bg-primary flex-shrink-0"></div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-8 text-center text-gray-500 flex flex-col items-center">
                        <span class="text-sm">Tidak ada notifikasi</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endif
