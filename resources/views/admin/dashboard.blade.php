<x-app-layout>
    {{-- NAVBAR --}}
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 fixed w-full z-30 top-0">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <!-- menu icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="text-lg font-semibold text-gray-900 dark:text-white">Dashboard</div>
                <p class="text-sm text-gray-500 dark:text-gray-400 ml-2 hidden md:block">Welcome back — here's what's happening today.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <input id="search" type="search" placeholder="Search..." class="w-56 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400" />
                    <button class="absolute right-1 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md text-sm text-blue-600">Search</button>
                </div>

                <button class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" title="Notifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/></svg>
                </button>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-700 dark:text-gray-300 hidden md:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-20">

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="w-72 bg-white dark:bg-gray-800 h-screen fixed border-r border-gray-200 dark:border-gray-700 transition-transform md:translate-x-0 -translate-x-full md:relative z-40">
            <div class="p-6">
                <div class="mb-6">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">Admin Panel</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Manage your application</div>
                </div>

                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18"/></svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Users
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2"/></svg>
                        Products
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                        Reports
                    </a>
                </nav>

                <div class="mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">System</div>
                    <div class="flex flex-col gap-2">
                        <a class="text-sm text-gray-600 dark:text-gray-300">Settings</a>
                        <a class="text-sm text-gray-600 dark:text-gray-300">Integrations</a>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="flex-1 ml-0 md:ml-72 p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-7xl mx-auto space-y-6">

                {{-- Top statistic cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Today's Revenue</p>
                                <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">Rp 4.2M</div>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">42 transactions</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-xs text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+15.3%</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
                        <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">1,248</div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">125 categories</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
                        <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">8,462</div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">234 new this week</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Low Stock Items</p>
                        <div class="mt-2 text-xl font-bold text-orange-600 dark:text-orange-400">24</div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Need restock soon</p>
                    </div>
                </div>

                {{-- Sales analytics (big) --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales Analytics</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last 7 days performance</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <button data-range="7" class="range-btn px-3 py-1 text-sm rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600">7 Days</button>
                            <button data-range="30" class="range-btn px-3 py-1 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">30 Days</button>
                            <button data-range="90" class="range-btn px-3 py-1 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">90 Days</button>
                        </div>
                    </div>

                    {{-- Chart area: SVG --}}
                    <div class="w-full h-64">
                        <svg id="sales-chart" class="w-full h-full" viewBox="0 0 800 200" preserveAspectRatio="none"></svg>
                    </div>

                    <div class="mt-3 flex gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Revenue</div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span> Transactions</div>
                    </div>
                </div>

                {{-- Lower grid: recent + top products --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Recent transactions (big) --}}
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-x-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                            <a href="#" class="text-sm text-blue-600 dark:text-blue-400">View All</a>
                        </div>

                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 dark:text-gray-300 border-b dark:border-gray-700">
                                    <th class="py-2">Order ID</th>
                                    <th class="py-2">Customer</th>
                                    <th class="py-2">Product</th>
                                    <th class="py-2">Amount</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 dark:text-gray-300">
                                @php
                                    $recent = [
                                        ['id' => '#INV-2847','name'=>'John Doe','product'=>'Wireless Earbuds','amount'=>'Rp 850K','status'=>'Completed'],
                                        ['id' => '#INV-2846','name'=>'Jane Smith','product'=>'Smart Watch','amount'=>'Rp 1.2M','status'=>'Pending'],
                                        ['id' => '#INV-2845','name'=>'Mike Johnson','product'=>'USB-C Cable','amount'=>'Rp 45K','status'=>'Completed'],
                                        ['id' => '#INV-2844','name'=>'Sarah Williams','product'=>'Phone Case','amount'=>'Rp 120K','status'=>'Processing'],
                                    ];
                                @endphp

                                @foreach($recent as $r)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="py-3 font-medium text-gray-800 dark:text-gray-100">{{ $r['id'] }}</td>
                                    <td class="py-3">{{ $r['name'] }}</td>
                                    <td class="py-3">{{ $r['product'] }}</td>
                                    <td class="py-3">{{ $r['amount'] }}</td>
                                    <td class="py-3">
                                        @if($r['status'] === 'Completed')
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span>
                                        @elseif($r['status'] === 'Pending')
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">{{ $r['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Top Products --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Products</h3>
                            <a href="#" class="text-sm text-blue-600 dark:text-blue-400">View all</a>
                        </div>

                        @php
                            $products = [
                                ['name'=>'Wireless Earbuds','sold'=>342,'price'=>'Rp 850K'],
                                ['name'=>'Smart Watch','sold'=>298,'price'=>'Rp 1.2M'],
                                ['name'=>'USB-C Cable','sold'=>256,'price'=>'Rp 45K'],
                                ['name'=>'Phone Case','sold'=>189,'price'=>'Rp 120K'],
                            ];
                        @endphp

                        <div class="space-y-3">
                            @foreach($products as $i => $p)
                            <div class="flex items-center justify-between gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold">{{ $i+1 }}</div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $p['name'] }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $p['sold'] }} sold</p>
                                    </div>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $p['price'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Bottom: quick actions + alerts --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Quick Actions</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <button class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600">Add User</button>
                            <button class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600">New Invoice</button>
                            <button class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600">View Reports</button>
                            <button class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700">Settings</button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Alerts</h3>
                        <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex items-start gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-orange-400 mt-1"></div>
                                <div>
                                    <p class="font-medium">Low stock: USB-C Cable</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">24 left — reorder soon</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 mt-1"></div>
                                <div>
                                    <p class="font-medium">Payment gateway maintenance</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Scheduled at 02:00 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> {{-- end max-width --}}
        </main>
    </div>

    {{-- Inline JS: chart + interactions (no external libs) --}}
    <script>
        (function(){
            // Sidebar toggle for small screens
            const btn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            btn?.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Sample datasets for chart (7 days)
            const datasets = {
                '7': {
                    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    revenue: [3200000, 4200000, 3900000, 5200000, 4800000, 6100000, 4300000],
                    tx: [32, 45, 38, 52, 47, 60, 42]
                },
                '30': { // generate simple pattern
                    labels: Array.from({length:30},(_,i)=>`D${i+1}`),
                    revenue: Array.from({length:30},()=> 2000000 + Math.floor(Math.random()*5000000)),
                    tx: Array.from({length:30},()=> 10 + Math.floor(Math.random()*80))
                },
                '90': {
                    labels: Array.from({length:90},(_,i)=>`D${i+1}`),
                    revenue: Array.from({length:90},()=> 2000000 + Math.floor(Math.random()*8000000)),
                    tx: Array.from({length:90},()=> 10 + Math.floor(Math.random()*120))
                }
            };

            // draw chart function (SVG area + line)
            function drawChart(range='7'){
                const cfg = datasets[range];
                const svg = document.getElementById('sales-chart');
                if(!svg) return;
                while(svg.firstChild) svg.removeChild(svg.firstChild);

                const padding = {top: 16, right: 24, bottom: 28, left: 48};
                const width = svg.clientWidth || 800;
                const height = svg.clientHeight || 200;
                const innerW = width - padding.left - padding.right;
                const innerH = height - padding.top - padding.bottom;
                const count = cfg.revenue.length;
                const maxRevenue = Math.max(...cfg.revenue) * 1.1;
                const minRevenue = Math.min(...cfg.revenue) * 0.9;

                // scales
                const x = (i) => padding.left + (i/(count-1)) * innerW;
                const y = (v) => padding.top + innerH - ((v - minRevenue)/(maxRevenue - minRevenue)) * innerH;

                // area path
                let areaD = `M ${x(0)} ${y(cfg.revenue[0])} `;
                for(let i=1;i<count;i++){
                    areaD += `L ${x(i)} ${y(cfg.revenue[i])} `;
                }
                areaD += `L ${x(count-1)} ${padding.top + innerH} L ${x(0)} ${padding.top + innerH} Z`;

                const area = document.createElementNS('http://www.w3.org/2000/svg','path');
                area.setAttribute('d', areaD);
                area.setAttribute('fill', 'rgba(59,130,246,0.12)'); // blue-500
                svg.appendChild(area);

                // line path
                let lineD = `M ${x(0)} ${y(cfg.revenue[0])} `;
                for(let i=1;i<count;i++){
                    lineD += `L ${x(i)} ${y(cfg.revenue[i])} `;
                }
                const line = document.createElementNS('http://www.w3.org/2000/svg','path');
                line.setAttribute('d', lineD);
                line.setAttribute('fill', 'none');
                line.setAttribute('stroke', '#2563EB');
                line.setAttribute('stroke-width', '2');
                line.setAttribute('stroke-linejoin','round');
                line.setAttribute('stroke-linecap','round');
                svg.appendChild(line);

                // dots + interactivity
                cfg.revenue.forEach((val,i)=>{
                    const cx = x(i);
                    const cy = y(val);
                    const circle = document.createElementNS('http://www.w3.org/2000/svg','circle');
                    circle.setAttribute('cx', cx);
                    circle.setAttribute('cy', cy);
                    circle.setAttribute('r', 4);
                    circle.setAttribute('fill', '#1E40AF');
                    circle.setAttribute('stroke', '#fff');
                    circle.setAttribute('stroke-width', '1');
                    circle.style.cursor = 'pointer';

                    // tooltip
                    circle.addEventListener('mouseenter', (e)=>{
                        showTooltip(e, cfg.labels[i], cfg.revenue[i], cfg.tx[i]);
                        circle.setAttribute('r',6);
                    });
                    circle.addEventListener('mouseleave', (e)=>{
                        hideTooltip();
                        circle.setAttribute('r',4);
                    });
                    svg.appendChild(circle);
                });

                // y axis labels (4 ticks)
                for(let t=0;t<=4;t++){
                    const v = minRevenue + (t/4)*(maxRevenue-minRevenue);
                    const yy = y(v);
                    const text = document.createElementNS('http://www.w3.org/2000/svg','text');
                    text.setAttribute('x', padding.left - 12);
                    text.setAttribute('y', yy + 4);
                    text.setAttribute('text-anchor','end');
                    text.setAttribute('fill','#9CA3AF'); // gray-400
                    text.setAttribute('font-size','11');
                    text.textContent = 'Rp ' + formatCurrency(Math.round(v/1000)) + 'K';
                    svg.appendChild(text);

                    // grid line
                    const grid = document.createElementNS('http://www.w3.org/2000/svg','line');
                    grid.setAttribute('x1', padding.left);
                    grid.setAttribute('x2', width - padding.right);
                    grid.setAttribute('y1', yy);
                    grid.setAttribute('y2', yy);
                    grid.setAttribute('stroke', '#E6E7E9');
                    grid.setAttribute('stroke-width', '0.8');
                    grid.setAttribute('opacity','0.6');
                    svg.appendChild(grid);
                }

                // x axis labels
                cfg.labels.forEach((lab,i)=>{
                    const tx = document.createElementNS('http://www.w3.org/2000/svg','text');
                    tx.setAttribute('x', x(i));
                    tx.setAttribute('y', padding.top + innerH + 18);
                    tx.setAttribute('text-anchor','middle');
                    tx.setAttribute('fill','#9CA3AF');
                    tx.setAttribute('font-size','11');
                    tx.textContent = lab;
                    svg.appendChild(tx);
                });
            }

            // tooltip DOM
            const tip = document.createElement('div');
            tip.id = 'chart-tooltip';
            tip.style.position = 'fixed';
            tip.style.pointerEvents = 'none';
            tip.style.padding = '8px 10px';
            tip.style.background = 'rgba(17,24,39,0.95)';
            tip.style.color = '#fff';
            tip.style.borderRadius = '8px';
            tip.style.fontSize = '12px';
            tip.style.zIndex = 9999;
            tip.style.display = 'none';
            document.body.appendChild(tip);

            function showTooltip(e, label, revenue, tx){
                const left = e.clientX + 12;
                const top = e.clientY - 28;
                tip.style.left = left + 'px';
                tip.style.top = top + 'px';
                tip.style.display = 'block';
                tip.innerHTML = `<div style="font-weight:600">${label}</div>
                                 <div style="font-size:12px;margin-top:4px">Revenue: Rp ${formatCurrency(Math.round(revenue/1000))}K</div>
                                 <div style="font-size:12px;margin-top:2px">Transactions: ${tx} orders</div>`;
            }
            function hideTooltip(){ tip.style.display = 'none'; }

            function formatCurrency(n){
                // n in thousands
                if(n >= 1000) return (n/1000).toFixed(1) + 'M';
                return n;
            }

            // initial draw
            drawChart('7');

            // range buttons
            document.querySelectorAll('.range-btn').forEach(btn=>{
                btn.addEventListener('click', (e)=>{
                    document.querySelectorAll('.range-btn').forEach(b=>b.classList.remove('bg-blue-50','text-blue-600'));
                    btn.classList.add('bg-blue-50','text-blue-600');
                    const r = btn.getAttribute('data-range');
                    drawChart(r);
                });
            });

            // responsive redraw on resize (debounce)
            let resizeTimer;
            window.addEventListener('resize', ()=>{
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(()=> drawChart(document.querySelector('.range-btn.bg-blue-50')?.getAttribute('data-range') || '7'), 200);
            });
        })();
    </script>

    <style>
        /* small helper to ensure sidebar animation works smoothly */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.-translate-x-full { transform: translateX(-100%); }
        }
    </style>
</x-app-layout>
