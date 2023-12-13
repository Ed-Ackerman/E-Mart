<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 900px;
            text-align: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            margin: auto;
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(to right, #3437db, #2b29b9);
            color: #ffffff;
            padding: 20px;
        }

        .card-body {
            width: 100%;
            max-width: 700px;
            padding: 5px 5px;
        }

        .list-group-item {
            border: none;
            padding: 3px 6px;
        }

        .card-footer {
            background: linear-gradient(to right, #e49826, #f1cc29);
            color: #ffffff;
            padding: 20px;
        }

        .btn-success {
            background-color: #00ff3c;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="display-4">Order Confirmation</h1>
                <p class="lead">Thank you for choosing us.</p>
            </div>

            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Order ID:</strong> {{ $checkout->id }}</li>
                    <li class="list-group-item"><strong>Name:</strong> {{ $checkout->name }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $checkout->order_status }}</li>
                    <li class="list-group-item">{{ $checkout->shipping_fee }}</li>
                </ul>
            </div>

            <div class="card-footer">
                <a href="https://www.zorithindustries.com/" class="btn-success">Shop More</a>
            </div>
        </div>
    </div>
</body>
</html>
