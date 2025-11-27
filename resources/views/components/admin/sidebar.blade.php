@props(['active' => 'dashboard'])

<aside id="sidebar" class="bg-white dark:bg-gray-800 h-screen fixed border-r border-gray-200 dark:border-gray-700 transition-all duration-300 z-40 w-72">
    <div class="p-6 pt-6">
        <div class="mb-6" id="sidebar-header">
            <div class="text-2xl font-bold text-gray-900 dark:text-white">Admin Panel</div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Manage your application</div>
        </div>

        <nav class="space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition group
                    {{ $active === 'dashboard' 
                        ? 'text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 font-medium' 
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $active === 'dashboard' ? 'text-blue-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            {{-- Users --}}
            <a href="{{ route('admin.users.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition group
                    {{ $active === 'users' 
                        ? 'text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 font-medium' 
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $active === 'users' ? 'text-blue-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="sidebar-text">Users</span>
            </a>

            {{-- Products --}}
            <a href="{{ route('admin.products.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition group
                    {{ $active === 'products' 
                        ? 'text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 font-medium' 
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $active === 'products' ? 'text-blue-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="sidebar-text">Products</span>
            </a>

            {{-- Reports --}}
            <a href="{{ route('admin.reports.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition group
                    {{ $active === 'reports' 
                        ? 'text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 font-medium' 
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $active === 'reports' ? 'text-blue-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="sidebar-text">Reports</span>
            </a>
        </nav>

        <div class="mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 sidebar-text">System</div>
            <div class="flex flex-col gap-2">
                <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 transition sidebar-text">Settings</a>
                <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 transition sidebar-text">Integrations</a>
            </div>
        </div>
    </div>
</aside>