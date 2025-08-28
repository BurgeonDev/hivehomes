<script>
    (function() {
        const APEX_CDN = 'https://cdn.jsdelivr.net/npm/apexcharts';
        const chartEl = document.querySelector('#lineAreaChart') || document.querySelector('#lineChart');
        if (!chartEl) {
            console.warn('Chart container not found');
            return;
        }

        // Theme vars (your top-of-page script sets these)
        // Using your chartColors definitions from page
        const _chartColors = (typeof chartColors !== 'undefined') ? chartColors : {
            area: {
                series1: '#29dac7',
                series2: '#60f2ca',
                series3: '#a5f8cd'
            }
        };
        const _labelColor = (typeof labelColor !== 'undefined') ? labelColor : '#6b6f82';
        const _legendColor = (typeof legendColor !== 'undefined') ? legendColor : '#6b6f82';
        const _borderColor = (typeof borderColor !== 'undefined') ? borderColor : '#e9ecef';
        const _cardColor = (typeof cardColor !== 'undefined') ? cardColor : '#ffffff';

        // load ApexCharts if missing
        function loadApexIfNeeded(cb) {
            if (window.ApexCharts) return cb();
            if (document.querySelector('script[data-apex-loader]')) {
                // wait until loaded
                const i = setInterval(() => {
                    if (window.ApexCharts) {
                        clearInterval(i);
                        cb();
                    }
                }, 100);
                setTimeout(() => clearInterval(i), 10000);
                return;
            }
            const s = document.createElement('script');
            s.src = APEX_CDN;
            s.async = true;
            s.setAttribute('data-apex-loader', '1');
            s.onload = cb;
            s.onerror = () => console.error('Failed to load ApexCharts');
            document.head.appendChild(s);
        }

        // render chart given server data
        function renderArea(growthData) {
            const categories = Array.isArray(growthData.categories) ? growthData.categories : [];
            const rawSeries = Array.isArray(growthData.series) ? growthData.series : [];
            const series = rawSeries.map(s => ({
                name: s.name || 'Series',
                data: Array.isArray(s.data) ? s.data : []
            }));
            if (!series.length) series.push({
                name: 'No Data',
                data: categories.map(() => 0)
            });

            // pick colors in the same order as your area example (series3, series2, series1)
            const colors = [
                _chartColors.area.series3 || '#a5f8cd',
                _chartColors.area.series2 || '#60f2ca',
                _chartColors.area.series1 || '#29dac7'
            ].slice(0, series.length);

            const markersStrokeColors = new Array(series.length).fill(_cardColor);
            const markersFillColors = colors;

            // compute yMax
            const flat = series.reduce((acc, s) => acc.concat(s.data), []);
            const maxVal = flat.length ? Math.max(...flat) : 100;
            const yMax = Math.max(10, Math.ceil(maxVal / 50) * 50);

            const areaChartConfig = {
                chart: {
                    height: 400,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    parentHeightOffset: 0
                },
                series: series,
                stroke: {
                    curve: 'straight',
                    width: 2
                },
                markers: {
                    strokeWidth: 7,
                    strokeOpacity: 1,
                    strokeColors: markersStrokeColors,
                    colors: markersFillColors
                },
                colors: colors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'start',
                    labels: {
                        colors: _legendColor
                    }
                },
                grid: {
                    borderColor: _borderColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                xaxis: {
                    categories: categories,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: _labelColor,
                            fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: yMax,
                    tickAmount: 4,
                    labels: {
                        style: {
                            colors: _labelColor,
                            fontSize: '13px'
                        }
                    }
                },
                // <-- gradient fill to ensure visible area under lines
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.6,
                        inverseColors: false,
                        opacityFrom: 0.6,
                        opacityTo: 0.08,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    shared: false
                }
            };

            try {
                // destroy previous instance
                if (chartEl._apexChart) {
                    chartEl._apexChart.destroy();
                    chartEl._apexChart = null;
                }
                const chart = new ApexCharts(chartEl, areaChartConfig);
                chart.render();
                chartEl._apexChart = chart;
            } catch (e) {
                console.error('renderArea error', e);
            }
        }

        // fetch growth from server
        async function fetchGrowth(range = '12m') {
            try {
                const res = await fetch("{{ route('dashboard.growth') }}?range=" + encodeURIComponent(range), {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) throw new Error('Network response was not ok');
                const data = await res.json();
                return data;
            } catch (err) {
                console.error('fetchGrowth error', err);
                return {
                    categories: [],
                    series: []
                };
            }
        }

        // wire up dropdown clicks
        function initControls() {
            document.querySelectorAll('.range-btn').forEach(el => {
                el.addEventListener('click', async function(ev) {
                    ev.preventDefault();
                    const r = this.getAttribute('data-range');
                    const loadingLabel = this.textContent;
                    // optional: show spinner or active state
                    const data = await fetchGrowth(r);
                    renderArea(data);
                });
            });
        }

        // initial load (12 months)
        loadApexIfNeeded(async function() {
            initControls();
            const initial = await fetchGrowth('12m');
            renderArea(initial);
        });

    })();
</script>
