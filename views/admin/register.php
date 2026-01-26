<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - My Order Fellow</title>
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

        .register-container {
            background-color: #2d2d2d;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            margin: 1rem;
        }

        .register-container h1 {
            color: #ffffff;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .register-container .subtitle {
            color: #9ca3af;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 2rem;
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

        .form-group.critical input {
            border-color: #ec4899;
        }

        .form-group.critical input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.3);
        }

        .form-group.critical label {
            color: #f472b6;
        }

        .critical-note {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.25rem;
            font-style: italic;
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
            margin-top: 0.5rem;
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

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #4b5563;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="admin-badge">
            <span>Admin Registration</span>
        </div>
        <h1>Create Admin Account</h1>
        <p class="subtitle">Register as a System Administrator</p>

        <?php if (isset($error)): ?>
            <div class="error-box">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/register">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="admin@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Create a strong password">
            </div>

            <div class="form-group critical">
                <label for="admin_secret">Master Access Code</label>
                <input type="password" id="admin_secret" name="admin_secret" required
                    placeholder="Enter the system secret key">
                <p class="critical-note">This code is required to authorize admin registration.</p>
            </div>

            <button type="submit" class="btn-submit">Create Account</button>
        </form>

        <div class="login-link">
            <a href="/admin/login">Already have an account? Login</a>
        </div>
    </div>
</body>

</html>