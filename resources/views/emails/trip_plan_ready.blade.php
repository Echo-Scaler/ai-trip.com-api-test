<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Trip Plan is Ready</title>
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
            color: #d946ef;
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

        .plan-content {
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            color: #e5e7eb;
            font-size: 14px;
            line-height: 1.6;
            border: 1px solid rgba(255, 255, 255, 0.05);
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
            background: linear-gradient(to right, #c026d3, #d946ef);
            color: white;
            border-radius: 12px;
            padding: 14px 0;
            font-weight: 600;
            text-decoration: none;
            margin-top: 24px;
        }

        .accent-text {
            color: #d946ef;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">TripExplorer AI</div>
            <div class="title">Your Custom Trip Plan</div>
            <div class="subtitle">We've crafted a personalized itinerary just for you.</div>
        </div>

        <div class="card">
            <p style="margin-top: 0;">Hello there!</p>
            <p>Based on our recent conversation, here is a summary of the <span class="accent-text">Trip Plan</span> our AI engine has generated for you:</p>

            <div class="plan-content">
                {!! nl2br(e($planSummary)) !!}
            </div>

            <p style="font-size: 13px; color: #9ca3af; margin-top: 20px;">You can view the full details and live flight/hotel availabilities by returning to our chat widget.</p>

            <a href="{{ config('app.url') }}" class="btn">Continue Your Trip Planning</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TripExplorer. Powered by Gemini AI & Trip.com API.<br>
            This is an automated notification. Please do not reply to this email.
        </div>
    </div>
</body>

</html>