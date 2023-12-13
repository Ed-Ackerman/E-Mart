@extends('layouts.app-master')

@section('content')
<legend>{{__('Overview')}} - {{ now()->format('d F Y') }}</legend>


<section class="dashboard-overview">
    <div class="over-view-cards">
        <!-- Total Users -->
        <div class="over-view-card" style="background: linear-gradient(to bottom left, #315e9e, #0735be);">
            <i class="fa fa-users"></i>
            <div class="over-view-number">{{ $totalUsers }}</div>
            <div class="over-view-name">{{__('Total Users')}}</div>
        </div>        

        <!-- Total Visitors -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #f3620f, #eba41f);">
            <i class="fa fa-eye"></i>
            <div class="over-view-number">
                {{ $cartPageViews }}
            </div>
            <div class="over-view-name">{{__('Total Visitors')}}</div>
        </div>
    
        <!-- Orders -->
        <div class="over-view-card" style="background: linear-gradient(to bottom right, #2fca88, #04db2f);">
            <i class="fa fa-shopping-cart"></i>
            <div class="over-view-number">{{ $totalOrders }}</div>
            <div class="over-view-name">{{ __('Total Orders') }}</div>
        </div>
        
        <!-- Total Categories -->
        <div class="over-view-card" style="background: linear-gradient(to top, #a45ac7, #c39bd3);">
            <i class="fa fa-folder"></i>
            <div class="over-view-number">{{ $totalCategories }}</div>
            <div class="over-view-name">{{__('Total Categories')}}</div>
        </div>
    </div>

    <div class="over-view-cards">
        <!-- Total Products -->
        <div class="over-view-card" style="background: linear-gradient(to bottom left, #ecb10c, #ffd700);">
            <i class="fa fa-cube"></i>
            <div class="over-view-number">{{ $totalProducts }}</div>
            <div class="over-view-name">{{__('Total Products')}}</div>
        </div>

        <!-- Earnings Per Month -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #dd860c, #ffb366);">
            <i class="fas fa-money"></i>
            @foreach($totalRevenuePerMonth as $month => $revenue)
                <div class="over-view-number">
                   {{ $revenue }}
                </div>
            @endforeach

            <div class="over-view-name">{{__('Net Earnings Per Month')}}</div>
        </div>

        <!-- Total Earnings -->
        <div class="over-view-card" style="background: linear-gradient(to bottom right, #07cead, #5ad6c7);">
            <i class="fas fa-money-bill-alt"></i>
            <div class="over-view-number">{{ $totalEarnings }}</div>
            <div class="over-view-name">{{__('Total Net Earnings')}}</div>
        </div>

        <!-- Total Sales -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #f06509, #ff8642);">
            <i class="fa fa-chart-line"></i>
            <div class="over-view-number">{{ $totalSales }}</div>
            <div class="over-view-name">{{__('Total Sales')}}</div>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<legend>{{__(('Quick Access'))}}</legend>

<section class="quick-actions">
    <a href="{{ route('users.index') }}" class="quick-action">
        <i class="fa fa-user-plus"></i>
        <div class="action-label">{{ __('Users Profile') }}</div>
    </a>
    <a href="{{ route('sales') }}" class="quick-action">
        <i class="fa fa-file-alt"></i>
        <div class="action-label">{{ __('Create Report') }}</div>
    </a>
    <a href="{{ route('proccessing') }}" class="quick-action">
        <i class="fa fa-cog"></i>
        <div class="action-label">{{ __('Order Processing') }}</div>
    </a>
    
    <a href="{{ route('products') }}" class="quick-action">
        <i class="fa fa-folder-plus"></i>
        <div class="action-label">{{ __('Product Catalog') }}</div>
    </a>
 
    <a href="{{ route('levels') }}" class="quick-action">
        <i class="fa fa-cubes"></i>
        <div class="action-label">{{ __('Stock Levels') }}</div>
    </a>
    <a href="{{ route('suppliers') }}" class="quick-action">
        <i class="fa fa-truck"></i>
        <div class="action-label">{{ __('Suppliers') }}</div>
    </a>
    <a href="{{ route('payment_get') }}" class="quick-action">
        <i class="fa fa-credit-card"></i>
        <div class="action-label">{{ __('Payment Gateways') }}</div>
    </a>
</section>

{{-- graphs --}}

<legend>{{__(('Overview Graphs'))}}</legend>

<section class="dashboard-graphs">
    <canvas id="lineChart-overview" style="background-color: #1a1a2e;"></canvas>

    <canvas id="barChart-overview" style="background-color: #1a1a2e;"></canvas>
</section>
@endsection
@section('custom-scripts')
    <!-- Page-specific scripts for dashboard 1 -->
    <script>

        $(document).ready(function () {
            var lineCtxOverview = document.getElementById('lineChart-overview').getContext('2d');

            // Make an AJAX request to get daily sales data for the current month using the named route
            $.ajax({
                url: '{{ route("daily.sales") }}',
                method: 'GET',
                success: function (response) {
                    var dailySalesData = response.data;

                    var lineChartDataOverview = {
                        labels: Object.keys(dailySalesData).map(day => day.padStart(2, '0')),
                        datasets: [{
                            label: 'Daily Sales',
                            data: Object.values(dailySalesData),
                            fill: true,
                            borderColor: '#3498db', // Use a modern color
                            backgroundColor: 'rgba(52, 152, 219, 0.2)', // Add a subtle fill
                            borderWidth: 2,
                            pointRadius: 5,
                            pointBackgroundColor: '#3498db', // Match the line color
                            pointBorderColor: '#fff', // White border for points
                            pointBorderWidth: 2,
                            tension: 0.4, // Add tension for a smoother curve
                            cubicInterpolationMode: 'monotone', // Use monotone interpolation
                        }]
                    };

                    var lineChartOverview = new Chart(lineCtxOverview, {
                        type: 'line',
                        data: lineChartDataOverview,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.1)', // Light gray grid lines
                                    },
                                    ticks: {
                                        color: 'white' // Y-axis labels color
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false, // Hide the x-axis grid lines
                                    },
                                    ticks: {
                                        color: 'white' // X-axis labels color
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top', // Show legend at the top
                                    labels: {
                                        color: 'white' // Legend text color
                                    }
                                },
                                title: {
                                    display: true,
                                    color: 'white',
                                    text: 'Monthly Sales Overview', // Add a title
                                    padding: {
                                        bottom: 10 // Add padding to the title
                                    }
                                },
                            },
                            animation: {
                                duration: 1000, // Add animation duration
                            },
                            interaction: {
                                mode: 'index', // Enable index mode for tooltips
                                intersect: false, // Allow tooltips to overlap
                            }
                        }
                    });

                    // Update the chart
                    lineChartOverview.update();
                }
            });
        });


        // Get canvas elements for the overview
        $(document).ready(function () {
            var barCtxOverview = document.getElementById('barChart-overview').getContext('2d');

            // Make an AJAX request to get monthly sales data using the named route
            $.ajax({
                url: '{{ route("monthly.sales") }}',
                method: 'GET',
                success: function (response) {
                    var monthlySalesData = response.data;

                    var barChartDataOverview = {
                        labels: Object.keys(monthlySalesData),
                        datasets: [{
                            label: 'Monthly Sales',
                            data: Object.values(monthlySalesData),
                            backgroundColor: 'rgba(52, 152, 219, 0.5)', // Use a modern color with opacity
                            borderColor: 'rgba(52, 152, 219, 1)', // Border color
                            borderWidth: 2
                        }]
                    };

                    var barChartOverview = new Chart(barCtxOverview, {
                        type: 'bar',
                        data: barChartDataOverview,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.1)', // Light gray grid lines
                                    },
                                    ticks: {
                                        color: 'white' // Y-axis labels color
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false, // Hide the x-axis grid lines
                                    },
                                    ticks: {
                                        color: 'white' // Y-axis labels color
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top', // Show legend at the top
                                    labels: {
                                        color: 'white', // Legend text color
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Annual Sales Overview', // Add a title
                                    color: 'white', // Title text color
                                    padding: {
                                        bottom: 10 // Add padding to the title
                                    }
                                },
                            },
                            animation: {
                                duration: 1000, // Add animation duration
                            },
                            interaction: {
                                mode: 'index', // Enable index mode for tooltips
                                intersect: false, // Allow tooltips to overlap
                            }
                        }
                    });

                    // Custom 3D-like effect
                    Chart.helpers.each(barChartOverview.getDatasetMeta(0).data, function (bar, index) {
                        var model = bar._model;
                        model.borderWidth = 1;
                        model.borderColor = 'rgba(52, 152, 219, ' + (1 - index / monthlySalesData.length) + ')';
                    });

                    // Update the chart
                    barChartOverview.update();
                }
            });
        });
    </script>

@endsection