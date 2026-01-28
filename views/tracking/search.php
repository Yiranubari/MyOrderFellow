<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Package - My Order Fellow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .tracking-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            border-radius: 16px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
        }

        .tracking-card h1 {
            font-size: 1.75rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .tracking-card p {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 1.1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            color: #1f2937;
            transition: border-color 0.2s, box-shadow 0.2s;
            text-align: center;
            letter-spacing: 0.05em;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        .form-group input::placeholder {
            color: #9ca3af;
            letter-spacing: normal;
        }

        .btn-track {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.3);
        }

        .btn-track:active {
            transform: translateY(0);
        }

        .footer-text {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .footer-text a {
            color: #1e3a5f;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="tracking-card">
        <div class="logo">MOF</div>
        <h1>Track Your Package</h1>
        <p>Enter your tracking number to see the latest status</p>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/track/result">
            <div class="form-group">
                <input
                    type="text"
                    name="tracking_id"
                    placeholder="Enter tracking number"
                    required
                    autocomplete="off">
            </div>
            <button type="submit" class="btn-track">Track Package</button>
        </form>

        <p class="footer-text">
            Need help? <a href="/contact">Contact Support</a>
        </p>
    </div>
</body>

</html>