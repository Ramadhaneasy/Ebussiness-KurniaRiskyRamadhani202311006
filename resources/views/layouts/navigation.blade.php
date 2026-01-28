@php
    $cartCount = auth()->check() ? auth()->user()->carts()->count() : 0;
    $role = auth()->check() ? (auth()->user()->role ?? 'user') : 'guest';
    $roleLabel = strtolower($role) === 'admin' ? 'Admin' : 'User';

    $name = auth()->check() ? auth()->user()->name : 'Guest';
    $initials = collect(explode(' ', $name))
        ->filter()
        ->take(2)
        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
        ->implode('');
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-40">
    <div class="bg-white/75 backdrop-blur border-b border-sky-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-3">

                <!-- Left: Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="p-2 rounded-xl bg-sky-50 border border-sky-100">
                            <x-application-logo class="block h-7 w-auto fill-current text-sky-700" />
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <div class="font-bold text-sky-900">{{ config('app.name', 'E-Commerce') }}</div>
                            <div class="text-xs text-sky-600">Blue Marketplace UI</div>
                        </div>
                    </a>
                </div>

                <!-- Center: Icon Nav (Desktop) -->
                <div class="hidden md:flex items-center gap-2">
                    @php
                        $nav = [
                            [
                                'label' => 'Dashboard',
                                'route' => 'dashboard',
                                'active' => request()->routeIs('dashboard'),
                                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            ],
                            [
                                'label' => 'Shop',
                                'route' => 'shop.index',
                                'active' => request()->routeIs('shop.*'),
                                'icon' => 'M3 3h18v4H3V3zm2 6h14l-1 12H6L5 9zm5 3h4m-5 4h6',
                            ],
                            [
                                'label' => 'My Orders',
                                'route' => 'orders.index',
                                'active' => request()->routeIs('orders.*'),
                                'icon' => 'M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14H5V6a2 2 0 012-2z',
                            ],
                            [
                                'label' => 'Cart',
                                'route' => 'cart.index',
                                'active' => request()->routeIs('cart.*'),
                                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z',
                                'badge' => $cartCount,
                            ],
                        ];
                    @endphp

                    @foreach($nav as $item)
                        <a href="{{ route($item['route']) }}"
                           class="group w-28 px-3 py-2 rounded-2xl border transition text-center
                                {{ $item['active']
                                    ? 'bg-sky-600 border-sky-600 text-white shadow-sm'
                                    : 'bg-white/60 border-sky-100 text-sky-900 hover:bg-sky-50' }}">
                            <div class="relative flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $item['active'] ? 'text-white' : 'text-sky-600 group-hover:text-sky-700' }}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>

                                @if(isset($item['badge']) && $item['badge'] > 0)
                                    <span class="absolute -top-2 -right-4 bg-rose-500 text-white text-[11px] font-bold rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-1 text-xs font-semibold tracking-wide">
                                {{ $item['label'] }}
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Right: Profile + Mobile Toggle -->
                <div class="flex items-center gap-2">

                    <!-- Profile Dropdown -->
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-3 px-3 py-2 rounded-2xl border border-sky-100 bg-white/60 hover:bg-sky-50 transition">
                                    <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-bold">
                                        {{ $initials ?: 'U' }}
                                    </div>

                                    <div class="hidden sm:block text-left leading-tight">
                                        <div class="text-sm font-semibold text-sky-900">{{ Auth::user()->name }}</div>
                                        <div class="text-xs">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 border border-sky-100 font-semibold">
                                                {{ $roleLabel }}
                                            </span>
                                        </div>
                                    </div>

                                    <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endauth

                    <!-- Mobile menu button -->
                    <button @click="open = !open"
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-xl border border-sky-100 bg-white/60 hover:bg-sky-50 transition">
                        <svg class="h-6 w-6 text-sky-700" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div x-show="open" class="md:hidden border-t border-sky-100 bg-white/80 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 py-4 grid grid-cols-4 gap-2">
                <a href="{{ route('dashboard') }}" class="p-3 rounded-2xl border border-sky-100 bg-white/60 text-center hover:bg-sky-50">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div class="mt-1 text-[11px] font-semibold">Dashboard</div>
                </a>

                <a href="{{ route('shop.index') }}" class="p-3 rounded-2xl border border-sky-100 bg-white/60 text-center hover:bg-sky-50">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v4H3V3zm2 6h14l-1 12H6L5 9zm5 3h4m-5 4h6"/>
                        </svg>
                    </div>
                    <div class="mt-1 text-[11px] font-semibold">Shop</div>
                </a>

                <a href="{{ route('orders.index') }}" class="p-3 rounded-2xl border border-sky-100 bg-white/60 text-center hover:bg-sky-50">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14H5V6a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <div class="mt-1 text-[11px] font-semibold">Orders</div>
                </a>

                <a href="{{ route('cart.index') }}" class="p-3 rounded-2xl border border-sky-100 bg-white/60 text-center hover:bg-sky-50 relative">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                        </svg>
                    </div>
                    <div class="mt-1 text-[11px] font-semibold">Cart</div>

                    @if($cartCount > 0)
                        <span class="absolute top-2 right-2 bg-rose-500 text-white text-[11px] font-bold rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>
