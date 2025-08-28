<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cardColor, headingColor, labelColor, borderColor, legendColor, fontFamily;

        cardColor = config.colors.cardColor;
        headingColor = config.colors.headingColor;
        labelColor = config.colors.textMuted;
        legendColor = config.colors.bodyColor;
        borderColor = config.colors.borderColor;
        fontFamily = config.fontFamily;

        window.chartColors = {
            column: {
                series1: '#826af9',
                series2: '#d2b0ff',
                bg: '#f8d3ff'
            },
            donut: {
                series1: '#fee802',
                series2: '#3fd0bd',
                series3: '#826bf8',
                series4: '#2b9bf4'
            },
            area: {
                series1: '#29dac7',
                series2: '#60f2ca',
                series3: '#a5f8cd'
            },
            bar: {
                bg: '#1D9FF2'
            }
        };

        fetch("{{ route('dashboard.service-providers-stats') }}")
            .then(response => response.json())
            .then(data => {
                const radialBarChartEl = document.querySelector('#radialBarChart');
                const radialBarChartConfig = {
                    chart: {
                        height: 348,
                        type: 'radialBar'
                    },
                    colors: [chartColors.donut.series1, chartColors.donut.series2, chartColors.donut
                        .series4
                    ],
                    plotOptions: {
                        radialBar: {
                            size: 185,
                            hollow: {
                                size: '40%'
                            },
                            track: {
                                margin: 10,
                                background: config.colors_label.secondary
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '1rem',
                                    fontFamily: fontFamily
                                },
                                value: {
                                    fontSize: '1.2rem',
                                    color: legendColor,
                                    fontFamily: fontFamily
                                },
                                total: {
                                    show: true,
                                    label: 'Total Providers',
                                    formatter: function() {
                                        return data.series.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        padding: {
                            top: -25,
                            bottom: 20
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: -30,
                        markers: {
                            size: '5px'
                        },
                        labels: {
                            colors: legendColor
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    series: data.series,
                    labels: data.labels
                };

                if (radialBarChartEl) {
                    const radialChart = new ApexCharts(radialBarChartEl, radialBarChartConfig);
                    radialChart.render();
                }
            });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const averageDailyPostsEl = document.querySelector('#averageDailyPosts');

        if (averageDailyPostsEl) {
            const seriesData = @json($series); // from Controller
            const labels = @json($labels); // dates (for x-axis if needed)

            const averageDailyPostsConfig = {
                chart: {
                    height: 105,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                markers: {
                    colors: 'transparent',
                    strokeColors: 'transparent'
                },
                grid: {
                    show: false
                },
                colors: [config.colors.success],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        gradientToColors: [config.colors.cardColor],
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Posts',
                    data: seriesData
                }],
                xaxis: {
                    categories: labels,
                    labels: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function(val) {
                            return val + " posts";
                        }
                    }
                },
                responsive: [{
                        breakpoint: 1387,
                        options: {
                            chart: {
                                height: 80
                            }
                        }
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 123
                            }
                        }
                    }
                ]
            };

            const averageDailyPostsChart = new ApexCharts(averageDailyPostsEl, averageDailyPostsConfig);
            averageDailyPostsChart.render();
        }
    });
</script>
