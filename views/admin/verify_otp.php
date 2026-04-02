<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin OTP Verification - My Order Fellow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verify-container {
            background-color: #f9fafb;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            margin: 1rem;
        }

        h1 {
            color: #1f2937;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .error-box {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            color: #1f2937;
            font-size: 1rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            color: #2563eb;
            text-decoration: none;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="verify-container">
        <h1>Verify Admin Email</h1>
        <p class="subtitle">Enter the 6-digit code sent to your email address.</p>

        <?php if (isset($error)): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/admin/verify">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required
                    value="<?= htmlspecialchars($email ?? ($_POST['email'] ?? '')) ?>">
            </div>

            <div class="form-group">
                <label for="otp_code">Verification Code</label>
                <input type="text" id="otp_code" name="otp_code" maxlength="6" required placeholder="123456"
                    value="<?= htmlspecialchars($_POST['otp_code'] ?? '') ?>">
            </div>

            <button type="submit" class="btn-submit">Verify & Create Admin</button>
        </form>

        <div class="back-link">
            <a href="/admin/register">Back to registration</a>
        </div>
    </div>
</body>

</html>