<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order Fellow</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --surface: #ffffff;
            --background: #f3f4f6;
            --text: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a.btn {
            background: var(--primary);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
        }

        .nav-links a.btn:hover {
            background: var(--primary-dark);
            color: white;
        }

        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: var(--surface);
            padding: 3rem 1.5rem;
        }

        .hero-icon {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .hero-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--text);
            font-weight: 700;
        }

        .hero p {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            color: var(--text-muted);
            max-width: 500px;
        }

        .track-box {
            background: var(--surface);
            padding: 0.5rem;
            border-radius: 12px;
            display: flex;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 500px;
        }

        .track-box input {
            flex: 1;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            outline: none;
            border-radius: 8px;
            background: transparent;
            color: var(--text);
        }

        .track-box input::placeholder {
            color: var(--text-muted);
        }

        .track-box button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .track-box button:hover {
            background: var(--primary-dark);
        }

        .features {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .feature {
            text-align: center;
            max-width: 200px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: var(--background);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
        }

        .feature-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--primary);
        }

        .feature h3 {
            font-size: 0.95rem;
            color: var(--text);
            margin-bottom: 0.25rem;
        }

        .feature p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
        }

        footer {
            text-align: center;
            padding: 1.5rem 2rem;
            color: var(--text-muted);
            font-size: 0.875rem;
            border-top: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .track-box {
                flex-direction: column;
                gap: 0.5rem;
                padding: 1rem;
            }

            .track-box input,
            .track-box button {
                width: 100%;
                border-radius: 8px;
            }

            footer {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="/" class="logo">My Order Fellow</a>
        <div class="nav-links">
            <a href="/login">Partner Login</a>
            <a href="/register" class="btn">Partner Sign Up</a>
            <a href="/admin/register" class="btn admin-btn">Admin Sign Up</a>
            .admin-btn {
            background: var(--primary-dark);
            color: #fff;
            margin-left: 0.5rem;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            }

            .admin-btn:hover {
            background: #22223b;
            }
        </div>
    </nav>

    <section class="hero">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" />
            </svg>
        </div>
        <h1>Track Your Shipment</h1>
        <p>Real-time updates for your packages, anywhere in the world.</p>

        <form action="/track/result" method="POST" class="track-box">
            <input type="text" name="tracking_id" placeholder="Enter Tracking ID (e.g., ORD-1234)" required>
            <button type="submit">Track</button>
        </form>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg>
                </div>
                <h3>Real-time Updates</h3>
                <p>Get instant notifications</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                </div>
                <h3>Location Tracking</h3>
                <p>Know where your package is</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                    </svg>
                </div>
                <h3>Secure & Reliable</h3>
                <p>Your data is protected</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> My Order Fellow. All rights reserved.</p>
        <a href="/admin/login">Admin Login</a>
    </footer>

</body>

</html>