<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order Fellow</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background: #f4f7f6;
        color: #333;
    }

    /* Navbar */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 50px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
        text-decoration: none;
    }

    .nav-links a {
        text-decoration: none;
        color: #555;
        margin-left: 20px;
        font-weight: 500;
    }

    .nav-links a.btn {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
    }

    /* Hero Section */
    .hero {
        height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
        color: white;
        padding: 20px;
    }

    .hero h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    /* Tracking Box */
    .track-box {
        background: white;
        padding: 10px;
        border-radius: 50px;
        display: flex;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 600px;
    }

    .track-box input {
        flex: 1;
        border: none;
        padding: 15px 25px;
        font-size: 18px;
        outline: none;
        border-radius: 50px 0 0 50px;
    }

    .track-box button {
        background: #007bff;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 18px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .track-box button:hover {
        background: #0056b3;
    }

    /* Footer */
    footer {
        text-align: center;
        padding: 20px;
        color: #777;
        font-size: 14px;
        margin-top: auto;
    }

    footer a {
        color: #777;
        text-decoration: none;
    }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="/" class="logo">📦 LogisticsCore</a>
        <div class="nav-links">
            <a href="/login">Partner Login</a>
            <a href="/register" class="btn">Partner Sign Up</a>
        </div>
    </nav>

    <section class="hero">
        <h1>Track Your Shipment</h1>
        <p>Real-time updates for your packages, anywhere in the world.</p>

        <form action="/track/result" method="POST" class="track-box">
            <input type="text" name="tracking_id" placeholder="Enter Tracking ID (e.g., ORD-1234)" required>
            <button type="submit">Track Package</button>
        </form>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Logistics Core System. <a href="/admin/login">Staff Login</a></p>
    </footer>

</body>

</html>