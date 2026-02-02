@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $name = $user->name ?? 'Admin';

    $initials = collect(explode(' ', $name))
        ->filter()
        ->take(2)
        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
        ->implode('');

    $unreadCount = $user->unreadNotifications()->count();
    $latestNotifications = $user->notifications()->latest()->limit(6)->get();
@endphp

<nav class="bg-white/75 backdrop-blur border-b border-sky-100 fixed w-full z-30 top-0">
    <div class="px-4 py-3 flex items-center justify-between gap-3">

        <!-- LEFT -->
        <div class="flex items-center gap-3">
            <button id="sidebar-toggle"
                class="p-2 rounded-xl text-sky-700 hover:bg-sky-50 border border-sky-100 bg-white/60 transition"
                title="Toggle sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="leading-tight">
                <div class="text-base font-bold text-sky-900">Seller Dashboard</div>
                <div class="text-xs text-sky-600 hidden sm:block">
                    Manage products • orders • reports
                </div>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="hidden md:block flex-1 max-w-md">
            <div class="relative">
                <input type="search" placeholder="Search products, orders..."
                    class="w-full px-4 py-2.5 pl-10 rounded-2xl border border-sky-100 bg-white/60 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                <svg class="w-5 h-5 text-sky-600 absolute left-3 top-1/2 -translate-y-1/2"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-2">

            <!-- 🔔 NOTIFICATIONS DROPDOWN -->
            <div class="relative" x-data="{ open:false }" @keydown.escape.window="open=false">
                <button
                    class="relative p-2 rounded-xl border border-sky-100 bg-white/60 hover:bg-sky-50 transition"
                    title="Notifications"
                    @click="open = !open"
                >
                    <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/>
                    </svg>

                    @if($unreadCount > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-rose-500 text-white text-[11px] font-bold rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

                <!-- DROPDOWN -->
                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top.right
                    @click.away="open=false"
                    class="absolute right-0 mt-2 w-96 rounded-2xl border border-sky-100 bg-white shadow-lg overflow-hidden z-50"
                >
                    <div class="px-4 py-3 flex items-center justify-between bg-sky-50 border-b border-sky-100">
                        <div class="font-bold text-sky-900">Notifications</div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.notifications.index') }}"
                               class="text-sm font-semibold text-sky-700 hover:underline">
                                View all
                            </a>

                            <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm font-semibold text-slate-600 hover:text-slate-800">
                                    Mark all
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="max-h-80 overflow-auto">
                        @forelse($latestNotifications as $n)
                            <form method="POST" action="{{ route('admin.notifications.read', $n->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 border-b border-sky-50 hover:bg-sky-50 transition {{ $n->read_at ? 'opacity-70' : '' }}">
                                    <div class="font-semibold text-sky-900 truncate">
                                        {{ $n->data['title'] ?? 'Notification' }}
                                        @if(!$n->read_at)
                                            <span class="ml-2 text-[10px] px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-slate-600">
                                        {{ $n->data['message'] ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $n->created_at->diffForHumans() }}
                                    </div>
                                </button>
                            </form>
                        @empty
                            <div class="px-4 py-6 text-slate-600">
                                No notifications.
                            </div>
                        @endforelse
                    </div>

                    <div class="px-4 py-3 bg-white border-t border-sky-100 text-xs text-slate-500">
                        {{ $unreadCount }} unread
                    </div>
                </div>
            </div>

            <!-- USER -->
            <div class="flex items-center gap-3 px-3 py-2 rounded-2xl border border-sky-100 bg-white/60">
                <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-bold">
                    {{ $initials ?: 'A' }}
                </div>

                <div class="hidden sm:block leading-tight">
                    <div class="text-sm font-semibold text-sky-900">{{ $name }}</div>
                    <div class="text-xs">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 border border-sky-100 font-semibold">
                            Admin
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="ml-2 text-sm font-semibold text-rose-600 hover:text-rose-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
