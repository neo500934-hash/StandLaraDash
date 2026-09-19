@extends('layouts.app')

@section('title', 'Dashboard')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <div class="la-dash-head">
            <div>
                <span class="la-kicker">Control Room</span>
                <h1 class="la-page-title">Business Operations Center</h1>
            </div>
            <div class="la-head-actions">
                <button class="btn btn-light btn-sm">Export</button>
                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>New Report</button>
            </div>
        </div>

        <div class="la-kpi-grid">
            <article class="card la-kpi-card">
                <div class="card-body">
                    <span class="la-kpi-label">Gross Revenue</span>
                    <strong class="la-kpi-value">$124,900</strong>
                    <span class="la-kpi-trend up"><i class="bi bi-arrow-up-right"></i> 6.4%</span>
                    <div class="la-kpi-chart" id="kpiRevenueChart"></div>
                </div>
            </article>

            <article class="card la-kpi-card">
                <div class="card-body">
                    <span class="la-kpi-label">New Customers</span>
                    <strong class="la-kpi-value">1,284</strong>
                    <span class="la-kpi-trend up"><i class="bi bi-arrow-up-right"></i> 3.1%</span>
                    <div class="la-kpi-chart" id="kpiCustomersChart"></div>
                </div>
            </article>

            <article class="card la-kpi-card">
                <div class="card-body">
                    <span class="la-kpi-label">Pending Orders</span>
                    <strong class="la-kpi-value">327</strong>
                    <span class="la-kpi-trend down"><i class="bi bi-arrow-down-right"></i> 1.7%</span>
                    <div class="la-kpi-chart" id="kpiOrdersChart"></div>
                </div>
            </article>

            <article class="card la-kpi-card">
                <div class="card-body">
                    <span class="la-kpi-label">Conversion Rate</span>
                    <strong class="la-kpi-value">4.92%</strong>
                    <span class="la-kpi-trend up"><i class="bi bi-arrow-up-right"></i> 0.8%</span>
                    <div class="la-kpi-chart" id="kpiConversionChart"></div>
                </div>
            </article>
        </div>

        <div class="la-layout-main">
            <section class="card la-card-revenue">
                <div class="card-header">
                    <h5 class="card-title">Revenue vs Cost (12 Weeks)</h5>
                </div>
                <div class="card-body">
                    <div class="la-revenue-meta">
                        <div><span class="dot revenue"></span>Revenue</div>
                        <div><span class="dot cost"></span>Cost</div>
                        <div><span class="dot profit"></span>Profit</div>
                    </div>
                    <div id="laRevenueMainChart" class="la-main-chart"></div>
                </div>
            </section>

            <section class="card la-ops-card">
                <div class="card-header">
                    <h5 class="card-title">Operations Snapshot</h5>
                </div>
                <div class="card-body">
                    <div class="la-weather-main">
                        <i class="bi bi-cloud-sun"></i>
                        <div>
                            <strong>68°</strong>
                            <p>San Francisco, CA</p>
                        </div>
                    </div>
                    <div class="la-weather-grid">
                        <div><span>Humidity</span><strong>64%</strong></div>
                        <div><span>Wind</span><strong>7 mph</strong></div>
                        <div><span>Rain</span><strong>15%</strong></div>
                        <div><span>UV</span><strong>Moderate</strong></div>
                    </div>
                    <div class="la-ops-divider"></div>
                    <div class="la-action-grid">
                        <a href="#"><i class="bi bi-people"></i><span>Users</span></a>
                        <a href="#"><i class="bi bi-receipt"></i><span>Invoices</span></a>
                        <a href="#"><i class="bi bi-headset"></i><span>Support</span></a>
                        <a href="#"><i class="bi bi-kanban"></i><span>Tasks</span></a>
                        <a href="#"><i class="bi bi-calendar3"></i><span>Calendar</span></a>
                        <a href="#"><i class="bi bi-person"></i><span>Profile</span></a>
                    </div>
                </div>
            </section>
        </div>

        <div class="la-widget-grid">
            <section class="card la-widget-card">
                <div class="card-header">
                    <h5 class="card-title">To Do List</h5>
                </div>
                <div class="card-body la-todo-list">
                    <label><input type="checkbox">Prepare executive summary</label>
                    <label><input type="checkbox" checked>Review pricing updates</label>
                    <label><input type="checkbox">Sync with product team</label>
                    <label><input type="checkbox">Approve campaign budget</label>
                    <label><input type="checkbox" checked>Close sprint planning</label>
                </div>
            </section>

            <section class="card la-widget-card">
                <div class="card-header">
                    <h5 class="card-title">Recent Comments</h5>
                </div>
                <div class="card-body la-comments-list">
                    <div class="la-comment-item">
                        <img src="{{ asset('assets/img/avatars/avatar-1.webp') }}" alt="">
                        <div><strong>Sarah Mitchell</strong>
                            <p>Dashboard KPI tiles look clear and readable.</p>
                        </div>
                        <small>6m</small>
                    </div>
                    <div class="la-comment-item">
                        <img src="{{ asset('assets/img/avatars/avatar-2.webp') }}" alt="">
                        <div><strong>David Chen</strong>
                            <p>Can we add one more segmentation filter?</p>
                        </div>
                        <small>18m</small>
                    </div>
                    <div class="la-comment-item">
                        <img src="{{ asset('assets/img/avatars/avatar-3.webp') }}" alt="">
                        <div><strong>Emily Rodriguez</strong>
                            <p>Support queue has improved after release.</p>
                        </div>
                        <small>28m</small>
                    </div>
                </div>
            </section>

            <section class="card la-widget-card">
                <div class="card-header">
                    <h5 class="card-title">Projects of the Week</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0 la-project-table">
                        <tbody>
                            <tr>
                                <td><span class="tag bg-primary">A</span> Aurora Redesign</td>
                                <td>78%</td>
                            </tr>
                            <tr>
                                <td><span class="tag bg-info">N</span> Nova CRM</td>
                                <td>64%</td>
                            </tr>
                            <tr>
                                <td><span class="tag bg-success">P</span> Pulse Mobile</td>
                                <td>49%</td>
                            </tr>
                            <tr>
                                <td><span class="tag bg-warning">V</span> Vertex API</td>
                                <td>84%</td>
                            </tr>
                            <tr>
                                <td><span class="tag bg-danger">S</span> Sigma Billing</td>
                                <td>31%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="la-analytics-grid">
            <section class="card la-card-traffic">
                <div class="card-header">
                    <h5 class="card-title">Traffic Composition</h5>
                </div>
                <div class="card-body">
                    <div id="laTrafficBarsChart" class="la-medium-chart"></div>
                </div>
            </section>

            <section class="card la-card-health">
                <div class="card-header">
                    <h5 class="card-title">Ticket Health</h5>
                </div>
                <div class="card-body">
                    <div id="laTicketHealthChart" class="la-medium-chart"></div>
                </div>
            </section>
        </div>

        <div class="la-footer-widgets">
            <section class="card la-storage-card">
                <div class="card-header">
                    <h5 class="card-title">Storage Allocation</h5>
                </div>
                <div class="card-body">
                    <p>Using <strong>6.85 GB</strong> of 8 GB</p>
                    <div class="la-storage-bars">
                        <span class="part-a"></span>
                        <span class="part-b"></span>
                        <span class="part-c"></span>
                        <span class="part-d"></span>
                    </div>
                    <div class="la-storage-legend">
                        <span><i class="bi bi-square-fill text-primary"></i> Media</span>
                        <span><i class="bi bi-square-fill text-info"></i> Backups</span>
                        <span><i class="bi bi-square-fill text-success"></i> Logs</span>
                        <span><i class="bi bi-square-fill text-warning"></i> Other</span>
                    </div>
                </div>
            </section>

            <section class="card la-social-card">
                <div class="card-header">
                    <h5 class="card-title">Social Pulse</h5>
                </div>
                <div class="card-body">
                    <div class="la-social-item"><i class="bi bi-twitter-x"></i><span>623 shares</span><small>+8%</small>
                    </div>
                    <div class="la-social-item"><i class="bi bi-facebook"></i><span>132 likes</span><small>+3%</small>
                    </div>
                    <div class="la-social-item"><i class="bi bi-instagram"></i><span>498
                            mentions</span><small>+11%</small></div>
                    <div class="la-social-item"><i class="bi bi-linkedin"></i><span>214 clicks</span><small>-1%</small>
                    </div>
                </div>
            </section>

            <section class="card la-alerts-card">
                <div class="card-header">
                    <h5 class="card-title">System Alerts</h5>
                </div>
                <div class="card-body">
                    <div class="la-alert-item warning"><strong>Storage reached 86%</strong><span>10m ago</span></div>
                    <div class="la-alert-item success"><strong>Payment gateway recovered</strong><span>32m ago</span></div>
                    <div class="la-alert-item info"><strong>New release deployed</strong><span>1h ago</span></div>
                    <div class="la-alert-item danger"><strong>2 failed login attempts</strong><span>2h ago</span></div>
                </div>
            </section>
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
