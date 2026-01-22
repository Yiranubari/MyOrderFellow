<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-box">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Welcome Back</h2>
    <?php if (isset($error)): ?>
        <div
            style="background-color: #fee2e2; color: #dc2626; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #fecaca;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Login to Dashboard</button>
    </form>

    <p style="text-align: center; margin-top: 1rem;">
        New partner? <a href="/register">Register here</a>
    </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>