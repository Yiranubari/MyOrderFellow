<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Console - My Order Fellow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: #2d2d2d;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .login-container h1 {
            color: #ffffff;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .error-box {
            background-color: #7f1d1d;
            border: 1px solid #dc2626;
            color: #fecaca;
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
            color: #d1d5db;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            background-color: #3d3d3d;
            border: 1px solid #4b5563;
            border-radius: 4px;
            color: #ffffff;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #2563eb;
        }

        .admin-badge {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .admin-badge span {
            display: inline-block;
            background-color: #4b5563;
            color: #9ca3af;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="admin-badge">
            <span>Admin Area</span>
        </div>
        <h1>Admin Console</h1>

        <?php if (isset($error)): ?>
            <div class="error-box">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="admin@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn-submit">Access Admin Panel</button>
        </form>
    </div>
</body>

</html>