{{-- @extends('layouts.app-master')

@section('content')
<legend>{{__(('Real-Time Metrics'))}}</legend>

<section class="dashboard-overview">
    <div class="over-view-cards">
        <!-- Real-Time Users -->
        <div class="over-view-card" style="background: linear-gradient(to bottom left, #315e9e, #0735be);">
            <i class="fa fa-users"></i>
            <div class="over-view-number">259</div>
            <div class="over-view-name">{{__('Real-Time Users')}}</div>
        </div>

        <!-- Page Views -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #f3620f, #eba41f);">
            <i class="fa fa-eye"></i>
            <div class="over-view-number">1387</div>
            <div class="over-view-name">{{__('Page Views')}}</div>
        </div>

        <!-- Orders Placed -->
        <div class="over-view-card" style="background: linear-gradient(to bottom right, #2fca88, #04db2f);">
            <i class="fa fa-shopping-cart"></i>
            <div class="over-view-number">42</div>
            <div class="over-view-name">{{__('Orders Placed')}}</div>
        </div>

        <!-- Active Users -->
        <div class="over-view-card" style="background: linear-gradient(to top, #a45ac7, #c39bd3);">
            <i class="fa fa-users"></i>
            <div class="over-view-number">88</div>
            <div class="over-view-name">{{__('Active Users')}}</div>
        </div>
    </div>

    <div class="over-view-cards">
        <!-- Product Views -->
        <div class="over-view-card" style="background: linear-gradient(to bottom left, #ecb10c, #ffd700);">
            <i class="fa fa-cube"></i>
            <div class="over-view-number">765</div>
            <div class="over-view-name">{{__('Product Views')}}</div>
        </div>

        <!-- Revenue Today -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #dd860c, #ffb366);">
            <i class="fa fa-money"></i>
            <div class="over-view-number">$1,234</div>
            <div class="over-view-name">{{__('Revenue Today')}}</div>
        </div>

        <!-- Total Earnings -->
        <div class="over-view-card" style="background: linear-gradient(to bottom right, #07cead, #5ad6c7);">
            <i class="fa fa-dollar"></i>
            <div class="over-view-number">$17,890</div>
            <div class="over-view-name">{{__('Total Earnings')}}</div>
        </div>

        <!-- Total Sales -->
        <div class="over-view-card" style="background: linear-gradient(to bottom, #f06509, #ff8642);">
            <i class="fa fa-chart-line"></i>
            <div class="over-view-number">189</div>
            <div class="over-view-name">{{__('Total Sales')}}</div>
        </div>
    </div>
</section>

<legend>{{__(('Quick Access'))}}</legend>
<section class="quick-actions">
    <a href="{{ route('users.index') }}" class="quick-action">
        <i class="fa fa-user-plus"></i>
        <div class="action-label">{{ __('Users Profile') }}</div>
    </a>
    <a href="{{ route('financial') }}" class="quick-action">
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

<legend>{{__(('Monthly Metrics'))}}</legend>

<section class="dashboard-graphs">
    <canvas id="barChart-monthly"></canvas>
    <canvas id="lineChart-monthly"></canvas>
</section>
@endsection
@section('custom-scripts')
    <!-- Page-specific scripts for dashboard 2 -->
    <script>
        
        // Get canvas elements for monthly data
        var barCtxMonthly = document.getElementById('barChart-monthly').getContext('2d');
        var lineCtxMonthly = document.getElementById('lineChart-monthly').getContext('2d');

        // Get the current month
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth(); // Month index (0-11)

        // Function to get the number of days in a month
        function getDaysInMonth(year, month) {
            return new Date(year, month + 1, 0).getDate();
        }

        // Function to generate labels for days of the month
        function generateDayLabels(year, month) {
            var days = [];
            var totalDays = getDaysInMonth(year, month);
            for (var i = 1; i <= totalDays; i++) {
                days.push(i.toString());
            }
            return days;
        }

        // Demo data for daily sales (replace with your actual data)
        var dailySalesData = [50, 60, 70, 80, 90, 85, 95, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220, 230, 240, 250, 260, 270, 280, 290, 300];

        // Define data for the bar chart (current month data)
        var barChartDataMonthly = {
            labels: generateDayLabels(currentDate.getFullYear(), currentMonth),
            datasets: [{
                label: 'Daily Sales',
                data: dailySalesData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Create the bar chart for monthly data
        var barChartMonthly = new Chart(barCtxMonthly, {
            type: 'bar',
            data: barChartDataMonthly,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Function to generate labels for weeks of the month
        function generateWeekLabels(year, month) {
            var weeks = [];
            var firstDay = new Date(year, month, 1).getDay(); // Day of the week (0-6) for the first day of the month
            var totalDays = getDaysInMonth(year, month);
            var currentWeek = [];
            
            for (var day = 1; day <= totalDays; day++) {
                currentWeek.push(day.toString());
                if ((firstDay + day) % 7 === 0 || day === totalDays) {
                    weeks.push(currentWeek.join('-'));
                    currentWeek = [];
                }
            }
            
            return weeks;
        }

        // Demo data for weekly revenue (replace with your actual data)
        var weeklyRevenueData = [200, 250, 300, 350, 400, 450];

        // Define data for the line chart (current month data)
        var lineChartDataMonthly = {
            labels: generateWeekLabels(currentDate.getFullYear(), currentMonth),
            datasets: [{
                label: 'Weekly Revenue',
                data: weeklyRevenueData,
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)'
            }]
        };

        // Create the line chart for monthly data
        var lineChartMonthly = new Chart(lineCtxMonthly, {
            type: 'line',
            data: lineChartDataMonthly,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
@endsection --}}