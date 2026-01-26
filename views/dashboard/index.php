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

    <?php if ($kycStatus === 'approved'): ?>

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

        <!-- Recent Orders Section -->
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

    <?php elseif ($kycStatus === 'submitted'): ?>
        <div
            style="max-width: 600px; margin: 3rem auto; background-color:#ffffff; padding: 2.5rem; border-radius: 12px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
            <h2 style="margin: 0 0 1rem 0; color: #1e40af; font-size: 1.5rem;">Application Under Review</h2>
            <p style="color: #374151; font-size: 1rem; line-height: 1.6; margin: 0;">
                Your documents have been received.<br>
                An admin will review them shortly.
            </p>
            <div
                style="margin-top: 1.5rem; padding: 0.75rem 1.5rem; background-color: #2563eb; border-radius: 8px; display: inline-block;">
                <span style="color: #ffffff; font-weight: 500;">⏳ Estimated review time: 1-2 business days</span>
            </div>
        </div>

    <?php else: ?>
        <div
            style="max-width: 600px; margin: 2rem auto; background: #ffffff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <h2 style="margin: 0 0 0.5rem 0; color: #1f2937; font-size: 1.5rem;">Complete Your KYC</h2>
            <p style="color: #6b7280; margin: 0 0 1.5rem 0; font-size: 0.875rem;">
                Please provide your business details to get approved for API access.
            </p>

            <form method="POST" action="/dashboard/submit-kyc">
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">
                        Business Registration Number
                    </label>
                    <input type="text" name="business_reg_no" required placeholder="e.g. RC-123456"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 4px; box-sizing: border-box; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">
                        Business Address
                    </label>
                    <textarea name="business_address" required rows="3" placeholder="Enter your full business address"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 4px; box-sizing: border-box; font-size: 1rem; resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">
                        Contact Person Name
                    </label>
                    <input type="text" name="contact_person" required placeholder="Full name of primary contact"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 4px; box-sizing: border-box; font-size: 1rem;">
                </div>

                <button type="submit"
                    style="width: 100%; padding: 0.875rem; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                    Submit for Approval
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>