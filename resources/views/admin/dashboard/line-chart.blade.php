<script>
    // growth data injected from controller
    const growthData = @json($growth);

    // existing theme variables that your template uses (legendColor, labelColor, borderColor, chartColors)
    // I'm assuming these are defined earlier by your theme scripts. If not, define defaults here:
    const legendColor = typeof legendColor !== 'undefined' ? legendColor : '#6b6f82';
    const labelColor = typeof labelColor !== 'undefined' ? labelColor : '#6b6f82';
    const borderColor = typeof borderColor !== 'undefined' ? borderColor : '#e9ecef';
    const chartColors = typeof chartColors !== 'undefined' ? chartColors : {
        const chartColors = typeof chartColors !== 'undefined' ? chartColors : {
            area: {
                series1: '#0d6efd',
                series2: '#20c997',
                series3: '#ffc107'
            },
            donut: {
                series1: '#0d6efd',
                series2: '#20c997',
                series3: '#ffc107',
                series4: '#dc3545' // extra color for safety
            }
        };

    };

    (function() {
        const areaChartEl = document.querySelector('#lineAreaChart'),
            areaChartConfig = {
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
                    show: false,
                    curve: 'straight'
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'start',
                    markers: {
                        size: '5px'
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
                // keep your theme chart color order (Products/Posts/Users or the order you like)
                colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
                // replace series with dynamic data
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
                    opacity: 1,
                    type: 'solid'
                },
                tooltip: {
                    shared: false
                }
            };

        if (typeof areaChartEl !== 'undefined' && areaChartEl !== null) {
            const areaChart = new ApexCharts(areaChartEl, areaChartConfig);
            areaChart.render();
        }
    })();
</script>
