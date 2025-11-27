<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    
    {{-- Navbar --}}
    <x-admin.navbar />

    <div class="flex pt-16">
        {{-- Sidebar --}}
        <x-admin.sidebar :active="$active ?? 'dashboard'" />

        {{-- Main Content --}}
        <main id="main-content" class="flex-1 p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-all duration-300" style="margin-left: 288px;">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Overlay untuk mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden transition-opacity duration-300"></div>

    {{-- JavaScript untuk sidebar toggle --}}
    <script>
        (function(){
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarHeader = document.getElementById('sidebar-header');
            
            let isCollapsed = false;
            let isMobile = window.innerWidth < 768;

            function updateLayout() {
                isMobile = window.innerWidth < 768;
                
                if (isMobile) {
                    // Mobile: sidebar hidden by default
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.style.marginLeft = '0';
                    overlay.classList.add('hidden');
                    isCollapsed = false;
                } else {
                    // Desktop: sidebar visible
                    sidebar.style.transform = 'translateX(0)';
                    if (isCollapsed) {
                        sidebar.style.width = '80px';
                        mainContent.style.marginLeft = '80px';
                        sidebarTexts.forEach(el => el.style.display = 'none');
                        sidebarHeader.style.display = 'none';
                    } else {
                        sidebar.style.width = '288px';
                        mainContent.style.marginLeft = '288px';
                        sidebarTexts.forEach(el => el.style.display = 'block');
                        sidebarHeader.style.display = 'block';
                    }
                    overlay.classList.add('hidden');
                }
            }

            toggleBtn?.addEventListener('click', () => {
                if (isMobile) {
                    // Mobile: slide in/out
                    if (sidebar.style.transform === 'translateX(-100%)' || sidebar.style.transform === '') {
                        sidebar.style.transform = 'translateX(0)';
                        overlay.classList.remove('hidden');
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        overlay.classList.add('hidden');
                    }
                } else {
                    // Desktop: collapse/expand
                    isCollapsed = !isCollapsed;
                    
                    if (isCollapsed) {
                        sidebar.style.width = '80px';
                        mainContent.style.marginLeft = '80px';
                        sidebarTexts.forEach(el => el.style.display = 'none');
                        sidebarHeader.style.display = 'none';
                    } else {
                        sidebar.style.width = '288px';
                        mainContent.style.marginLeft = '288px';
                        sidebarTexts.forEach(el => el.style.display = 'block');
                        sidebarHeader.style.display = 'block';
                    }
                }
            });

            overlay?.addEventListener('click', () => {
                if (isMobile) {
                    sidebar.style.transform = 'translateX(-100%)';
                    overlay.classList.add('hidden');
                }
            });

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(updateLayout, 200);
            });

            updateLayout();
        })();
    </script>

    @stack('scripts')
</body>
</html>