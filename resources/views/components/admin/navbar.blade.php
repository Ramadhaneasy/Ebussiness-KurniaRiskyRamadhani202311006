<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 fixed w-full z-30 top-0">
    <div class="px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="text-lg font-semibold text-gray-900 dark:text-white">Admin Dashboard</div>
            <p class="text-sm text-gray-500 dark:text-gray-400 hidden lg:block">
                Welcome back — here's what's happening today.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
                <input id="search" type="search" placeholder="Search..." 
                    class="w-56 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400" />
            </div>

            <button class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" title="Notifications">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/>
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-700 dark:text-gray-300 hidden md:inline">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:red-600 text-sm transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>