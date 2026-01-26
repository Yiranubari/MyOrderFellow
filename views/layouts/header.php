<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order Fellow</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <nav class="navbar">
        <a href="/" class="brand">My Order Fellow</a>
        <div class="nav-links">
            <?php if (isset($_SESSION['company_id'])): ?>
                <a href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="container"></main>