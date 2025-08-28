 {{-- Script: make the line chart look like your example but with 3 series (Users, Products, Posts) --}}
 <script>
     (function() {
         // growth data injected from controller
         const growthData = @json($growth ?? ['categories' => [], 'series' => []]);

         // Defensive fallbacks for theme variables (so chart won't error out)
         const globalConfig = window.config || {
             colors: {
                 warning: '#ff9f43',
                 info: '#0d6efd',
                 success: '#20c997'
             }
         };
         const cardColor = window.cardColor || '#ffffff';
         const labelColor = window.labelColor || '#6b6f82';
         const borderColor = window.borderColor || '#e9ecef';

         // prefer your original container id if present, otherwise fallback to #lineChart
         const chartEl = document.querySelector('#lineAreaChart') || document.querySelector('#lineChart');

         if (!chartEl) {
             console.warn('Line chart container not found (#lineAreaChart or #lineChart).');
             return;
         }

         // Ensure growthData structure
         const categories = Array.isArray(growthData.categories) ? growthData.categories : [];
         // convert series to Apex-friendly format: [{ name, data: [...] }, ...]
         const rawSeries = Array.isArray(growthData.series) ? growthData.series : [];
         const series = rawSeries.map(s => ({
             name: s.name ?? 'Series',
             data: Array.isArray(s.data) ? s.data : []
         }));

         // If no series data present, create a single zero-series to avoid errors
         if (series.length === 0) {
             series.push({
                 name: 'No Data',
                 data: categories.map(() => 0)
             });
         }

         // compute axis max (nice rounded multiple) so chart looks like sample (min:0)
         const flatten = series.reduce((acc, cur) => acc.concat(cur.data), []);
         const maxVal = flatten.length ? Math.max(...flatten) : 100;
         const yMax = Math.max(10, Math.ceil(maxVal / 50) * 50); // round up to nearest 50 for a clean top

         // choose colors for series (map to your theme colors; extend if more than 3)
         const palette = [
             globalConfig.colors.info || '#0d6efd',
             globalConfig.colors.success || '#20c997',
             globalConfig.colors.warning || '#ff9f43'
         ];
         // if more series than palette, repeat palette
         const colors = series.map((_, idx) => palette[idx % palette.length]);

         // markers strokeColors should be cardColor repeated for each series (matches your sample)
         const markersStrokeColors = new Array(series.length).fill(cardColor);
         const markersFillColors = colors; // marker fill = series color (like sample)

         const lineChartConfig = {
             chart: {
                 height: 400,
                 type: 'line',
                 parentHeightOffset: 0,
                 zoom: {
                     enabled: false
                 },
                 toolbar: {
                     show: false
                 }
             },
             series: series,
             markers: {
                 strokeWidth: 7,
                 strokeOpacity: 1,
                 strokeColors: markersStrokeColors,
                 colors: markersFillColors
             },
             dataLabels: {
                 enabled: false
             },
             stroke: {
                 curve: 'straight'
             },
             colors: colors,
             grid: {
                 borderColor: borderColor,
                 xaxis: {
                     lines: {
                         show: true
                     }
                 },
                 padding: {
                     top: -20
                 }
             },
             tooltip: {
                 // custom tooltip that shows series name and raw value (no misleading %)
                 custom: function({
                     series,
                     seriesIndex,
                     dataPointIndex,
                     w
                 }) {
                     const label = w.config.series[seriesIndex].name || '';
                     const value = series[seriesIndex][dataPointIndex];
                     const x = (w.config.xaxis && w.config.xaxis.categories && w.config.xaxis.categories[
                         dataPointIndex]) || '';
                     return '<div class="px-3 py-2">' +
                         '<div class="mb-1 fw-semibold">' + label + (x ? (' — ' + x) : '') + '</div>' +
                         '<div>' + value + '</div>' +
                         '</div>';
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
                         colors: labelColor,
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
                         colors: labelColor,
                         fontSize: '13px'
                     }
                 }
             },
             legend: {
                 show: true,
                 position: 'top',
                 horizontalAlign: 'start',
                 markers: {
                     width: 8,
                     height: 8
                 },
                 labels: {
                     colors: labelColor
                 }
             }
         };

         try {
             // remove previous chart (if any) to prevent duplicates when re-rendering
             if (chartEl._apexChart) {
                 chartEl._apexChart.destroy();
                 chartEl._apexChart = null;
             }

             const lineChart = new ApexCharts(chartEl, lineChartConfig);
             lineChart.render();

             // keep reference to chart instance on element (useful for future updates/destroys)
             chartEl._apexChart = lineChart;
         } catch (err) {
             console.error('Failed to render line chart:', err);
         }
     })();
 </script>
