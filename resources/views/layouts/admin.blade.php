<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sellify') }} - Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-sky-50 via-white to-sky-50 text-gray-800">
    <x-admin.navbar />

    <div class="flex pt-16">
        <x-admin.sidebar :active="$active ?? 'dashboard'" />

        <div id="main-content"
             class="flex-1 p-6 min-h-screen transition-all duration-300"
             style="margin-left: 288px;">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-2xl bg-white/80 backdrop-blur border border-sky-100 shadow-sm p-4 sm:p-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 z-20 hidden transition-opacity duration-300"></div>

    <script>
        (function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarHeader = document.getElementById('sidebar-header');
            const sidebarLinks = document.querySelectorAll('.sidebar-link');

            const EXPANDED_WIDTH = 288; // w-72
            const COLLAPSED_WIDTH = 72; // icon-only
            let isCollapsed = false;
            let isMobile = window.innerWidth < 1024; // lg breakpoint

            function styleLinksCollapsed() {
                sidebarLinks.forEach(a => {
                    a.style.justifyContent = 'center';
                    a.style.gap = '0px';
                    a.style.paddingLeft = '0.75rem';
                    a.style.paddingRight = '0.75rem';
                });
            }

            function styleLinksExpanded() {
                sidebarLinks.forEach(a => {
                    a.style.justifyContent = '';
                    a.style.gap = '';
                    a.style.paddingLeft = '';
                    a.style.paddingRight = '';
                });
            }

            function applyDesktop() {
                sidebar.style.transform = 'translateX(0)';
                overlay.classList.add('hidden');

                if (isCollapsed) {
                    sidebar.style.width = COLLAPSED_WIDTH + 'px';
                    mainContent.style.marginLeft = COLLAPSED_WIDTH + 'px';
                    sidebarTexts.forEach(el => el.style.display = 'none');
                    if (sidebarHeader) sidebarHeader.style.display = 'none';
                    styleLinksCollapsed();
                } else {
                    sidebar.style.width = EXPANDED_WIDTH + 'px';
                    mainContent.style.marginLeft = EXPANDED_WIDTH + 'px';
                    sidebarTexts.forEach(el => el.style.display = 'block');
                    if (sidebarHeader) sidebarHeader.style.display = 'block';
                    styleLinksExpanded();
                }
            }

            function applyMobile() {
                mainContent.style.marginLeft = '0';
                sidebar.style.width = EXPANDED_WIDTH + 'px';
                sidebarTexts.forEach(el => el.style.display = 'block');
                if (sidebarHeader) sidebarHeader.style.display = 'block';
                sidebar.style.transform = 'translateX(-100%)';
                overlay.classList.add('hidden');
                isCollapsed = false;
                styleLinksExpanded();
            }

            function updateLayout() {
                isMobile = window.innerWidth < 1024;
                if (isMobile) applyMobile();
                else applyDesktop();
            }

            toggleBtn?.addEventListener('click', () => {
                if (isMobile) {
                    const hidden = sidebar.style.transform === 'translateX(-100%)' || sidebar.style.transform === '';
                    if (hidden) {
                        sidebar.style.transform = 'translateX(0)';
                        overlay.classList.remove('hidden');
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        overlay.classList.add('hidden');
                    }
                } else {
                    isCollapsed = !isCollapsed;
                    applyDesktop();
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
                resizeTimer = setTimeout(updateLayout, 150);
            });

            updateLayout();
        })();
    </script>

    @stack('scripts')
</body>
</html>
