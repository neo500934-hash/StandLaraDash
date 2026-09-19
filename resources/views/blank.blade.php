@extends('layouts.app')

@section('title', 'Dashboard')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <div class="la-dash-head">
            {{-- <div>
                <span class="la-kicker">Control Room</span>
                <h1 class="la-page-title">Business Operations Center</h1>
            </div> --}}
            {{-- <div class="la-head-actions">
        <button class="btn btn-light btn-sm">Export</button>
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>New Report</button>
      </div> --}}
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            'use strict';
            if (typeof ApexCharts === 'undefined') return;
            const charts = [];

            function cssVar(name) {
                return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
            }

            function mount(selector, options) {
                const el = document.querySelector(selector);
                if (!el) return;
                const chart = new ApexCharts(el, options);
                chart.render();
                charts.push(chart);
            }

            function destroyAll() {
                while (charts.length) {
                    const chart = charts.pop();
                    if (chart) chart.destroy();
                }
            }

            function renderAll() {
                const accent = cssVar('--accent-color');
                const success = cssVar('--success-color');
                const warning = cssVar('--warning-color');
                const danger = cssVar('--danger-color');
                const info = cssVar('--info-color');
                const muted = cssVar('--muted-color');
                const border = cssVar('--border-color');
                const spark = (selector, data, color) => mount(selector, {
                    chart: {
                        type: 'line',
                        height: 52,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: false
                        }
                    },
                    series: [{
                        data
                    }],
                    colors: [color],
                    stroke: {
                        curve: 'smooth',
                        width: 2.2
                    },
                    tooltip: {
                        enabled: false
                    }
                });
                spark('#kpiRevenueChart', [12, 18, 15, 21, 19, 24, 22, 28, 30], accent);
                spark('#kpiCustomersChart', [9, 11, 10, 12, 14, 15, 13, 17, 18], success);
                spark('#kpiOrdersChart', [20, 19, 21, 18, 17, 18, 16, 15, 14], warning);
                spark('#kpiConversionChart', [3.2, 3.7, 3.4, 3.9, 4.2, 4.1, 4.4, 4.6, 4.9], info);
                mount('#laRevenueMainChart', {
                    chart: {
                        type: 'line',
                        height: 260,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: false
                        }
                    },
                    series: [{
                            name: 'Revenue',
                            data: [52, 56, 54, 62, 66, 64, 72, 74, 79, 84, 86, 90]
                        },
                        {
                            name: 'Cost',
                            data: [31, 33, 34, 38, 40, 41, 44, 46, 49, 52, 53, 55]
                        },
                        {
                            name: 'Profit',
                            data: [21, 23, 20, 24, 26, 23, 28, 28, 30, 32, 33, 35]
                        }
                    ],
                    colors: [accent, warning, success],
                    stroke: {
                        curve: 'smooth',
                        width: [2.8, 2.2, 2.2]
                    },
                    xaxis: {
                        categories: ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8', 'W9', 'W10', 'W11', 'W12'],
                        labels: {
                            style: {
                                colors: muted,
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: muted,
                                fontSize: '12px'
                            }
                        }
                    },
                    grid: {
                        borderColor: border,
                        strokeDashArray: 4
                    },
                    legend: {
                        show: false
                    }
                });
                mount('#laTrafficBarsChart', {
                    chart: {
                        type: 'bar',
                        height: 250,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: false
                        }
                    },
                    series: [{
                            name: 'Organic',
                            data: [22, 26, 24, 31, 34, 37, 35, 41, 44, 42, 47, 49]
                        },
                        {
                            name: 'Paid',
                            data: [14, 16, 15, 18, 22, 24, 25, 27, 30, 28, 31, 35]
                        }
                    ],
                    colors: [accent, info],
                    plotOptions: {
                        bar: {
                            columnWidth: '42%',
                            borderRadius: 2
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        labels: {
                            style: {
                                colors: muted,
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: muted,
                                fontSize: '12px'
                            }
                        }
                    },
                    grid: {
                        borderColor: border,
                        strokeDashArray: 4
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        labels: {
                            colors: muted
                        }
                    }
                });
                mount('#laTicketHealthChart', {
                    chart: {
                        type: 'donut',
                        height: 250,
                        animations: {
                            enabled: false
                        }
                    },
                    series: [54, 28, 18],
                    labels: ['Resolved', 'In Progress', 'Overdue'],
                    colors: [success, accent, danger],
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: muted
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        colors: [cssVar('--surface-color')]
                    }
                });
            }

            function rerender() {
                destroyAll();
                renderAll();
            }
            renderAll();
            document.addEventListener('themeChanged', rerender);
            const observer = new MutationObserver(function(mutations) {
                for (let i = 0; i < mutations.length; i += 1) {
                    if (mutations[i].attributeName === 'data-theme') {
                        rerender();
                        break;
                    }
                }
            });
            observer.observe(document.documentElement, {
                attributes: true
            });
        })();
    </script>
@endpush
