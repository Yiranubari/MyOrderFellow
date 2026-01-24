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


    <div
        style="background: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: #1f2937;">API Integration</h3>

        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Your Secret
                Key</label>
            <input type="text" readonly value="<?= htmlspecialchars($apiKey ?? '') ?>"
                placeholder="<?= empty($apiKey) ? 'No key generated yet' : '' ?>"
                style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 4px; background-color: #f9fafb; color: #374151; box-sizing: border-box;">
        </div>

        <form method="POST" action="/dashboard/generate-key">
            <button type="submit"
                style="padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                Generate Secret Key
            </button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>