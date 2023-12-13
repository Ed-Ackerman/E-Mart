<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Request</title>
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
            padding: 5px 5px;
        }

        .list-group-item {
            width: 100%;
            border: none;
            padding: 3px 6px;
        }

        .card-footer {
            background: linear-gradient(to right, #e49826, #f1cc29);
            color: #ffffff;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="display-4">New Order Request</h1>
                <p class="lead"> You have a new order request.</p>
            </div>

            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Order ID:</strong> {{ $checkout->id }}</li>
                    <li class="list-group-item"><strong>Name:</strong> {{ $checkout->name }}</li>
                    <li class="list-group-item"><strong>Location:</strong> {{ $checkout->address }}</li>
                    <li class="list-group-item"><strong>Phone No.:</strong>  {{ $checkout->tel_1 }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $checkout->order_status }}</li>
                </ul>
            </div>

            <div class="card-footer"></div>
        </div>
    </div>
</body>
</html>
