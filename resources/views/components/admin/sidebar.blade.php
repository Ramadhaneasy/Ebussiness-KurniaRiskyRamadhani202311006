@props(['active' => 'dashboard'])

<aside id="sidebar"
    class="bg-white/70 backdrop-blur h-screen fixed border-r border-sky-100 transition-all duration-300 z-40 w-72">
    <div class="px-4 py-5">
        <div class="mb-6" id="sidebar-header">
            <div class="text-xl font-extrabold text-sky-900">Admin Panel</div>
            <div class="text-xs text-sky-600 mt-1">Seller tools & management</div>
        </div>

        @php
            $items = [
                ['key'=>'dashboard','label'=>'Dashboard','route'=>'admin.dashboard','icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['key'=>'products','label'=>'Products','route'=>'admin.products.index','icon'=>'M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0H4m16 0l-2 8H6l-2-8'],
                ['key'=>'users','label'=>'Users','route'=>'admin.users.index','icon'=>'M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H2v-2a4 4 0 014-4h1m6-4a4 4 0 10-8 0 4 4 0 008 0zm6 4a3 3 0 10-6 0 3 3 0 006 0z'],
                ['key'=>'reports','label'=>'Reports','route'=>'admin.reports.index','icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h8l4 4v12a2 2 0 01-2 2z'],
            ];
        @endphp

        <nav class="space-y-2">
            @foreach($items as $it)
                @php $isActive = $active === $it['key']; @endphp

                <a href="{{ route($it['route']) }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl border transition
                   {{ $isActive ? 'bg-sky-600 border-sky-600 text-white shadow-sm' : 'bg-white/50 border-sky-100 text-sky-900 hover:bg-sky-50' }}">
                    <div class="sidebar-icon-wrap w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $isActive ? 'bg-white/15' : 'bg-white/0' }}">
                        <svg class="sidebar-icon w-6 h-6 {{ $isActive ? 'text-white' : 'text-sky-600' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="{{ $it['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="sidebar-text font-semibold">{{ $it['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-6 pt-4 border-t border-sky-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl border border-sky-100 bg-white/50 hover:bg-rose-50 hover:border-rose-200 transition">
                    <div class="sidebar-icon-wrap w-10 h-10 rounded-xl flex items-center justify-center">
                        <svg class="sidebar-icon w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                    </div>
                    <span class="sidebar-text font-semibold">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
