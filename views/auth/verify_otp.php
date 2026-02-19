<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-box auth-center">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Verify Account</h2>

    <?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <p style="text-align: center; margin-bottom: 1.5rem; color: #6b7280; font-size: 0.875rem;">
        We sent a 6-digit code to your email.<br>Enter it below to confirm your account.
    </p>

    <form action="/verify" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['verify_email'] ?? '') ?>">

        <div class="form-group">
            <label for="otp_code">OTP Code</label>
            <input type="text" id="otp_code" name="otp_code" required
                style="text-align: center; letter-spacing: 0.5rem; font-size: 1.25rem;" placeholder="123456"
                maxlength="6">
        </div>

        <button type="submit" class="btn">Verify Code</button>
    </form>

    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #6b7280;">
        Didn't receive the code?
    <form action="/resend-otp" method="POST" style="display: inline;">
        <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['verify_email'] ?? '') ?>">
        <button type="submit" style="background: none; border: none; color: #3b82f6; cursor: pointer; font-size: 0.875rem; padding: 0; text-decoration: underline;">Resend OTP</button>
    </form>
    </p>

    <p style="text-align: center; margin-top: 1rem;">
        Wrong email? <a href="/register">Register again</a>
    </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>