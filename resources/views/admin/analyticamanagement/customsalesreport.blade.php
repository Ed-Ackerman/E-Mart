<!DOCTYPE html>
<html>
<head>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            text-transform: capitalize;
        }

        .card {
            width: 30%;
            margin: 10px;
            padding: 3px;
            border: 1px solid #ccc;
            border-radius: 5px;
            float: right;
        }

        .card-header {
            background-color: #f5f5f5;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
        }

        .card-body {
            padding: 10px;
        }

        .card-item {
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: center;
        }

        .card-item-title {
            width: 100%;
            font-size: 14px;
            font-weight: bold;
        }

        .card-item-content {
            width: 100%;
            font-size: 14px;
            color: #3a3a3a;
            padding: 10px 5px;
        }

        .report-header {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            flex-wrap: wrap;
            /* flex-direction: row; */
            align-items: flex-start;
            justify-content: space-between;
        }

        .company-details {
            width: 50vw;
            text-align: right;
        }

        .report-details {
            width: 50vw;
            text-align: left;
            padding: 5px 10px;
            text-indent: 20px;
        }

        .report-header h1 {
            font-size: 24px;
            font-weight: 500;
            padding: 5px 10px;
        }

        .report-header p {
            font-size: 15px;
            line-height: 20px;
            padding: 5px 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
            border-bottom: 1px solid #0c0c0c;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
        }

        td {
            color: #1a1a1a;
            font-size: 14px;
            padding: 10px;
            border-bottom: 1px solid #0c0c0c;
            border-right: 1px solid #f3f3f3;
        }

    </style>
</head>
<body>
    <div class="report-header">
        <div class="company-details">
          <h2>{{__('E-Mart')}}</h2>
          <p>{{__('Kampala-Uganda')}}</p>
          <p>{{__('+256-788276076')}}</p>
          <p>{{__('www.emart.com')}}</p>
        </div>
        <div class="report-details">
            <h1>{{__('Custom Sales Report')}}</h1>
            <p>{{__('Start Date : ')}} {{ $startDate }}</p>
            <p>{{__('End Date :  ')}}{{ $endDate }}</p>
        </div>
      </div>
      
    <table>
        <thead>
            <tr>
                <th>{{__('ID_No.')}}</th>
                <th>{{__('Pdt_ID.')}}</th>
                <th>{{__('Cust_Pdt_Name')}}</th>
                <th>{{__('Cust_Qty')}}</th>
                <th>{{__('Cust_Price')}}</th>
                <th>{{__('Cust_Total')}}</th>
            </tr>
            
        </thead>
        <tbody>
            @php
            // Custom function to convert strings with commas to numbers
                function convertToNumber($value) {
                    return (float) str_replace(',', '', $value);
                }
            
                $totalItemsSold = 0;
                $totalSales = 0;
                $totalNetProfits = 0;
            @endphp
            @foreach ($salesData as $custom)
                @foreach ($custom['custom_order'] as $item)
                   
                    <tr>
                        <th>{{ $custom['id'] }}</th>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['custom_name'] }}</td>
                        <td>{{ $item['custom_qty'] }}</td>
                        <td>{{ $item['custom_price'] }}</td>
                        <td>{{ $item['custom_total'] }}</td>
                    </tr>
                    @php
                        // Increment the totals
                        $totalItemsSold += convertToNumber($item['custom_qty']);
                        $totalSales += convertToNumber($item['custom_total']);
                    @endphp
                @endforeach
            @endforeach
        </tbody>
        
        
    </table>
    
    <div class="card overall">
        <div class="card-header">{{ __('Overall') }}</div>
    
        <div class="card-body">
            <div class="card-item">
                <div class="card-item-title">{{ __('Total items sold') }}</div>
                <div class="card-item-content">{{__('items : ')}}{{ number_format($totalItemsSold) }}</div>
            </div>
        
            <div class="card-item">
                <div class="card-item-title">{{ __('Total Selling / sales') }}</div>
                <div class="card-item-content">{{__('UGX : ')}}{{ number_format($totalSales) }}</div>
            </div>
        </div>
        
    </div>
    

</body>
</html>
