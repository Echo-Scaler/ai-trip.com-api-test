<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #0a0816;
            color: #d1d5db;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .card {
            background-color: #1e1b2e;
            border-radius: 16px;
            border: 1px solid #2d2a3e;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #3490fc;
            text-decoration: none;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 14px;
            color: #9ca3af;
        }

        .ref-badge {
            display: inline-block;
            background-color: rgba(52, 144, 252, 0.1);
            border: 1px solid rgba(52, 144, 252, 0.2);
            color: #3490fc;
            border-radius: 8px;
            padding: 4px 12px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 16px;
        }

        .section {
            margin-top: 32px;
            border-top: 1px solid #2d2a3e;
            padding-top: 24px;
        }

        .label {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .value {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            padding: 16px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .price-label {
            font-weight: 600;
            color: #ffffff;
        }

        .price-value {
            font-size: 20px;
            font-weight: 800;
            color: #3490fc;
        }

        .footer {
            text-align: center;
            margin-top: 32px;
            font-size: 12px;
            color: #6b7280;
        }

        .btn {
            display: inline-block;
            width: 100%;
            text-align: center;
            background: linear-gradient(to right, #1e70f1, #3490fc);
            color: white;
            border-radius: 12px;
            padding: 14px 0;
            font-weight: 600;
            text-decoration: none;
            margin-top: 24px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">TripExplorer</div>
            <div class="title">Booking Confirmed!</div>
            <div class="subtitle">Thank you for booking with us, {{ $booking['first_name'] }}.</div>
            <div class="ref-badge">REF: {{ $bookingRef }}</div>
        </div>

        <div class="card">
            <div class="label">Reservation for</div>
            <div class="value">{{ $booking['item_name'] }}</div>

            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <div class="label">Type</div>
                    <div class="value" style="text-transform: capitalize;">{{ $booking['type'] }}</div>
                </div>
                <div style="flex: 1;">
                    <div class="label">Customer</div>
                    <div class="value">{{ $booking['first_name'] }} {{ $booking['last_name'] }}</div>
                </div>
            </div>

            <div class="label">Email Address</div>
            <div class="value">{{ $booking['email'] }}</div>

            <div class="price-row">
                <span class="price-label">Total Amount</span>
                <span class="price-value">{{ number_format($booking['price'], 2) }} {{ $booking['currency'] }}</span>
            </div>

            <a href="{{ config('app.url') }}" class="btn">Manage Your Booking</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TripExplorer. Powered by Trip.com API.<br>
            This is an automated notification. Please do not reply to this email.
        </div>
    </div>
</body>

</html>