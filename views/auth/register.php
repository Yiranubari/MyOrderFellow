<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-box">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Create Account</h2>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="/register" method="POST">
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" id="name" name="name" required placeholder="e.g. Acme Logistics">
        </div>

        <div class="form-group">
            <label for="email">Business Email</label>
            <input type="email" id="email" name="email" required placeholder="you@company.com">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">
        </div>

        <button type="submit" class="btn">Register Company</button>
    </form>

    <p style="text-align: center; margin-top: 1rem;">
        Already have an account? <a href="/login">Login here</a>
    </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>