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
            <h1>{{__('Sales Report')}}</h1>
            <p>{{__('Start Date : ')}} {{ $startDate }}</p>
            <p>{{__('End Date :  ')}}{{ $endDate }}</p>
        </div>
      </div>
      
    <table>
        <thead>
            <tr>
                <th>{{__('ID_No.')}}</th>
                <th>{{__('Pdt_ID.')}}</th>
                <th>{{__('Pdt_Name')}}</th>
                <th>{{__('Pdt_Code')}}</th>
                <th>{{__('Qty')}}</th>
                <th>{{__('U_Buying')}}</th>
                <th>{{__('U_Selling')}}</th>
                <th>{{__('N_Profit')}}</th>
                <th>{{__('T_Buying')}}</th>
                <th>{{__('T_Selling')}}</th>
                <th>{{__('T_Net_Profit')}}</th>
                <th>{{__('Int_Exp')}}</th>
            </tr>
            
        </thead>
        <tbody>
            @foreach ($salesData as $checkout)
                @foreach ($checkout['cart_items'] as $cartItem)
                    @php
                    // Fetch additional details for the product based on product_id
                    $product = \App\Models\Admin\ProductManagement\Product::find($cartItem['product_id']);
                    @endphp
                    <tr>
                        <th>{{ $checkout['id'] }}</th>
                        <td>{{ $product ? $product->id : 'Product Not Found' }}</td>
                        <td>{{ $product ? $product->name : 'Product Not Found' }}</td>
                        <td>{{ $product ? $product->code : 'Product Not Found' }}</td>
                        <td>{{ $cartItem['quantity'] }}</td>
                        <td>{{ $product ? $product->buying : 'Product Not Found' }}</td>
                        <td>{{ $product ? $product->selling : 'Product Not Found' }}</td>
                        <td>
                            {{ 
                                $product ? 
                                number_format((float) str_replace(',', '', $product->selling) - (float) str_replace(',', '', $product->buying)) 
                                : 'Product Not Found' 
                            }}
                        </td>
                        <td>
                            {{ 
                                $product ? 
                                number_format(str_replace(',', '', $cartItem['quantity']) * (float) str_replace(',', '', $product->buying)) 
                                : 'Product Not Found' 
                            }}
                        </td>
                        <td>
                            {{ 
                                $product ? 
                                number_format(str_replace(',', '', $cartItem['quantity']) * (float) str_replace(',', '', $product->selling)) 
                                : 'Product Not Found' 
                            }}
                        </td>
                        <td>
                            {{ 
                                $product ? 
                                number_format(str_replace(',', '', $cartItem['quantity']) * (float) str_replace(',', '', $product->selling) - 
                                (str_replace(',', '', $cartItem['quantity']) * (float) str_replace(',', '', $product->buying))) 
                                : 'Product Not Found' 
                            }}
                        </td>
                        <td>{{ $product ? $product->expense : 'Product Not Found' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        
    </table>
    
    <div class="card overall">
        <div class="card-header">{{ __('Overall') }}</div>
    
        <div class="card-body">
            @php
                $totalItemsSold = 0;
                $totalExpense = 0;
                $totalSales = 0;
                $totalBuy = 0;
                $totalNetProfits = 0;
    
                foreach ($salesData as $checkout) {
                    foreach ($checkout['cart_items'] as $cartItem) {
                        $product = \App\Models\Admin\ProductManagement\Product::find($cartItem['product_id']);
    
                        if ($product) {
                            $totalItemsSold += $cartItem['quantity'];
                            $totalExpense += (float) str_replace(',', '',$product->expense);
                            $totalSales += $cartItem['quantity'] * (float) str_replace(',', '', $product->selling);
                            $totalBuy += $cartItem['quantity'] * (float) str_replace(',', '', $product->buying);
                            $totalNetProfits += ($cartItem['quantity'] * (float) str_replace(',', '', $product->selling)) - ($cartItem['quantity'] * (float) str_replace(',', '', $product->buying));
                        }
                    }
                }
            @endphp
    
            <div class="card-item">
                <div class="card-item-title">{{ __('Total items sold') }}</div>
                <div class="card-item-content">{{__('items : ')}}{{ $totalItemsSold }}</div>
            </div>
    
            <div class="card-item">
                <div class="card-item-title">{{ __('Total expenses / taxes, labour, transit') }}</div>
                <div class="card-item-content">{{__('UGX : ')}}{{ number_format($totalExpense) }}</div>
            </div>
    
            <div class="card-item">
                <div class="card-item-title">{{ __('Total Selling / sales') }}</div>
                <div class="card-item-content">{{__('UGX : ')}}{{ number_format($totalSales) }}</div>
            </div>

            <div class="card-item" style="  border-bottom: 1px solid #0c0c0c;">
                <div class="card-item-title">{{ __('Total Buying / bought') }}</div>
                <div class="card-item-content">{{__('UGX : ')}}{{ number_format($totalBuy) }}</div>
            </div>
    
            <div class="card-item">
                <div class="card-item-title">{{ __('Total Net Revenue / profits') }}</div>
                <div class="card-item-content">{{__('UGX : ')}}{{ number_format($totalNetProfits) }}</div>
            </div>
        </div>
    </div>
    

</body>
</html>
