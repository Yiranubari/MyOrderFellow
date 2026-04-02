<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <h1>Public Marketplace Order</h1>

    <div style="max-width: 720px; margin-top: 1rem; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
        <?php if (!empty($error)): ?>
            <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/orders/store">
            <div style="margin-bottom: 1rem;">
                <label for="company_id" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Select Logistics Company</label>
                <select id="company_id" name="company_id" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    <option value="">-- Choose a company --</option>
                    <?php foreach (($approvedCompanies ?? []) as $company): ?>
                        <option value="<?= (int) $company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h3 style="margin: 1.5rem 0 0.75rem; color: #1f2937;">Customer Contact</h3>

            <div style="margin-bottom: 1rem;">
                <label for="customer_name" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Full Name</label>
                <input id="customer_name" name="customer_name" type="text" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="customer_email" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Email</label>
                <input id="customer_email" name="customer_email" type="email" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="customer_phone" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Phone</label>
                <input id="customer_phone" name="customer_phone" type="text" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <h3 style="margin: 1.5rem 0 0.75rem; color: #1f2937;">Delivery Details</h3>

            <div style="margin-bottom: 1rem;">
                <label for="item_description" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Item Description</label>
                <textarea id="item_description" name="item_description" rows="3" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="pickup_address" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Pickup Address</label>
                <textarea id="pickup_address" name="pickup_address" rows="3" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="delivery_address" style="display:block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Delivery Address</label>
                <textarea id="delivery_address" name="delivery_address" rows="4" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <button type="submit" class="btn" style="width:auto;">Submit Order</button>
        </form>

        <?php if (empty($approvedCompanies ?? [])): ?>
            <p style="margin-top: 1rem; color: #9ca3af;">
                No approved logistics companies are available yet.
            </p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>