/**
 * Dashboard Analytics
 */

'use strict';

(function () {
    let cardColor, headingColor, fontFamily, labelColor;
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;

    // swiper loop and autoplay
    // --------------------------------------------------------------------
    const swiperWithPagination = document.querySelector('#swiper-with-pagination-cards');
    if (swiperWithPagination) {
        new Swiper(swiperWithPagination, {
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                clickable: true,
                el: '.swiper-pagination'
            }
        });
    }





    // Total Earning Chart - Bar Chart
    // --------------------------------------------------------------------
    const totalEarningChartEl = document.querySelector('#totalEarningChart'),
        totalEarningChartOptions = {
            chart: {
                height: 175,
                parentHeightOffset: 0,
                stacked: true,
                type: 'bar',
                toolbar: { show: false }
            },
            series: [
                {
                    name: 'Earning',
                    data: [300, 200, 350, 150, 250, 325, 250, 270]
                },
                {
                    name: 'Expense',
                    data: [-180, -225, -180, -280, -125, -200, -125, -150]
                }
            ],
            tooltip: {
                enabled: false
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    borderRadius: 7,
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadiusApplication: 'around',
                    borderRadiusWhenStacked: 'last'
                }
            },

            colors: [config.colors.primary, config.colors.secondary],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 5,
                lineCap: 'round',
                colors: [cardColor]
            },
            legend: {
                show: false
            },
            colors: [config.colors.primary, config.colors.secondary],
            fill: {
                opacity: 1
            },
            grid: {
                show: false,
                padding: {
                    top: -40,
                    bottom: -40,
                    left: -10,
                    right: -2
                }
            },
            xaxis: {
                labels: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            responsive: [
                {
                    breakpoint: 1700,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '43%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 1441,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '50%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 1300,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                columnWidth: '60%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 1200,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                columnWidth: '30%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 991,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                columnWidth: '35%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 850,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '50%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 768,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '30%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 476,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '43%'
                            }
                        }
                    }
                },
                {
                    breakpoint: 394,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '58%'
                            }
                        }
                    }
                }
            ],
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                },
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };
    if (typeof totalEarningChartEl !== undefined && totalEarningChartEl !== null) {
        const totalEarningChart = new ApexCharts(totalEarningChartEl, totalEarningChartOptions);
        totalEarningChart.render();
    }


})();
