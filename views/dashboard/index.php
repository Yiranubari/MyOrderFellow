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


    <div class="auth-box" style="max-width: 100%; text-align: left; margin-top: 1.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: #1f2937;">API Key</h3>

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

    <div class="auth-box" style="max-width: 100%; text-align: left; margin-top: 1.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: #1f2937;">Recent Orders</h3>

        <?php if (empty($orders)): ?>
            <p style="color: #6b7280; font-style: italic;">No orders received yet.</p>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 0.75rem; text-align: left; color: #374151; font-weight: 600;">Order ID
                                (External)</th>
                            <th style="padding: 0.75rem; text-align: left; color: #374151; font-weight: 600;">Date</th>
                            <th style="padding: 0.75rem; text-align: left; color: #374151; font-weight: 600;">Customer Email
                            </th>
                            <th style="padding: 0.75rem; text-align: left; color: #374151; font-weight: 600;">Delivery
                                Address</th>
                            <th style="padding: 0.75rem; text-align: left; color: #374151; font-weight: 600;">Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <?php
                            $items = json_decode($order['items'] ?? '[]', true);
                            $itemsList = is_array($items) ? implode(', ', $items) : '';
                            ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem; color: #1f2937;">
                                    <?= htmlspecialchars($order['external_order_id'] ?? '') ?></td>
                                <td style="padding: 0.75rem; color: #6b7280;">
                                    <?= htmlspecialchars($order['created_at'] ?? '') ?></td>
                                <td style="padding: 0.75rem; color: #1f2937;">
                                    <?= htmlspecialchars($order['customer_email'] ?? '') ?></td>
                                <td style="padding: 0.75rem; color: #1f2937;">
                                    <?= htmlspecialchars($order['delivery_address'] ?? '') ?></td>
                                <td style="padding: 0.75rem; color: #6b7280;"><?= htmlspecialchars($itemsList) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>