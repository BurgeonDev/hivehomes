<script>
    // growth data injected from controller
    const growthData = @json($growth);

    // define theme colors if not already available
    const legendColor = (typeof window.legendColor !== 'undefined') ? window.legendColor : '#6b6f82';
    const labelColor = (typeof window.labelColor !== 'undefined') ? window.labelColor : '#6b6f82';
    const borderColor = (typeof window.borderColor !== 'undefined') ? window.borderColor : '#e9ecef';

    const chartColors = (typeof window.chartColors !== 'undefined') ? window.chartColors : {
        area: {
            series1: '#0d6efd',
            series2: '#20c997',
            series3: '#ffc107'
        },
        donut: {
            series1: '#0d6efd',
            series2: '#20c997',
            series3: '#ffc107',
            series4: '#dc3545'
        }
    };

    (function() {
        const areaChartEl = document.querySelector('#lineAreaChart');

        if (!areaChartEl) return;

        const areaChartConfig = {
            chart: {
                height: 400,
                type: 'area',
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true, // ✅ show lines
                curve: 'smooth', // ✅ smoother look
                width: 2
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'start',
                markers: {
                    size: 5
                },
                labels: {
                    colors: legendColor,
                    useSeriesColors: false
                }
            },
            grid: {
                borderColor: borderColor,
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            colors: [
                chartColors.area.series3,
                chartColors.area.series2,
                chartColors.area.series1
            ],
            series: growthData.series,
            xaxis: {
                categories: growthData.categories,
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
                tickAmount: 4,
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px'
                    }
                }
            },
            fill: {
                opacity: 0.4, // ✅ softer fill under lines
                type: 'solid'
            },
            tooltip: {
                shared: true
            }
        };

        const areaChart = new ApexCharts(areaChartEl, areaChartConfig);
        areaChart.render();
    })();
</script>
