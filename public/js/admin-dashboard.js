(function(){
    // Data untuk chart berdasarkan range
    const datasets = {
        '7': {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            revenue: [3200000, 4200000, 3900000, 5200000, 4800000, 6100000, 4300000],
            tx: [32, 45, 38, 52, 47, 60, 42]
        },
        '30': {
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

    // Fungsi untuk draw chart
    function drawChart(range='7'){
        const cfg = datasets[range];
        const svg = document.getElementById('sales-chart');
        if(!svg) return;
        
        // Clear chart
        while(svg.firstChild) svg.removeChild(svg.firstChild);

        const padding = {top: 16, right: 24, bottom: 28, left: 48};
        const width = svg.clientWidth || 800;
        const height = svg.clientHeight || 200;
        const innerW = width - padding.left - padding.right;
        const innerH = height - padding.top - padding.bottom;
        const count = cfg.revenue.length;
        const maxRevenue = Math.max(...cfg.revenue) * 1.1;
        const minRevenue = Math.min(...cfg.revenue) * 0.9;

        // Scale functions
        const x = (i) => padding.left + (i/(count-1)) * innerW;
        const y = (v) => padding.top + innerH - ((v - minRevenue)/(maxRevenue - minRevenue)) * innerH;

        // Draw area
        let areaD = `M ${x(0)} ${y(cfg.revenue[0])} `;
        for(let i=1; i<count; i++) {
            areaD += `L ${x(i)} ${y(cfg.revenue[i])} `;
        }
        areaD += `L ${x(count-1)} ${padding.top + innerH} L ${x(0)} ${padding.top + innerH} Z`;

        const area = document.createElementNS('http://www.w3.org/2000/svg','path');
        area.setAttribute('d', areaD);
        area.setAttribute('fill', 'rgba(59,130,246,0.12)');
        svg.appendChild(area);

        // Draw line
        let lineD = `M ${x(0)} ${y(cfg.revenue[0])} `;
        for(let i=1; i<count; i++) {
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

        // Draw dots
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

            circle.addEventListener('mouseenter', ()=> circle.setAttribute('r',6));
            circle.addEventListener('mouseleave', ()=> circle.setAttribute('r',4));
            svg.appendChild(circle);
        });

        // Y-axis labels
        for(let t=0; t<=4; t++){
            const v = minRevenue + (t/4)*(maxRevenue-minRevenue);
            const yy = y(v);
            const text = document.createElementNS('http://www.w3.org/2000/svg','text');
            text.setAttribute('x', padding.left - 12);
            text.setAttribute('y', yy + 4);
            text.setAttribute('text-anchor','end');
            text.setAttribute('fill','#9CA3AF');
            text.setAttribute('font-size','11');
            text.textContent = 'Rp ' + Math.round(v/1000) + 'K';
            svg.appendChild(text);
        }

        // X-axis labels
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

    // Initial draw
    drawChart('7');

    // Range button handlers
    document.querySelectorAll('.range-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            document.querySelectorAll('.range-btn').forEach(b=>{
                b.classList.remove('bg-blue-50','text-blue-600');
                b.classList.add('text-gray-600');
            });
            btn.classList.add('bg-blue-50','text-blue-600');
            btn.classList.remove('text-gray-600');
            drawChart(btn.getAttribute('data-range'));
        });
    });

    // Redraw on resize
    let resizeTimer;
    window.addEventListener('resize', ()=>{
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(()=> {
            const activeBtn = document.querySelector('.range-btn.bg-blue-50');
            drawChart(activeBtn?.getAttribute('data-range') || '7');
        }, 200);
    });
})();