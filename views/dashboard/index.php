<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <h1>Dashboard</h1>
    <div class="auth-box" style="max-width: 100%; text-align: left;">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['company_name']); ?>!</h2>
        <p>Your Company ID is: <strong><?php echo $_SESSION['company_id']; ?></strong></p>

        <hr>

        <p>Status: <span style="color: green; font-weight: bold;">Logged In</span></p>

        <a href="/logout" class="btn" style="width: auto; display: inline-block; background-color: #dc2626;">Logout</a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>