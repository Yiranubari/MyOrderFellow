<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <h1>Public Marketplace Order</h1>

    <div class="auth-box" style="max-width: 720px; margin-top: 1rem; text-align: left;">
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/orders/store">
            <div class="form-group">
                <label for="company_id">Select Logistics Company</label>
                <select id="company_id" name="company_id" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    <option value="">-- Choose a company --</option>
                    <?php foreach (($approvedCompanies ?? []) as $company): ?>
                        <option value="<?= (int) $company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h3 style="margin: 1.5rem 0 0.75rem; color: #1f2937;">Customer Contact</h3>

            <div class="form-group">
                <label for="customer_name">Full Name</label>
                <input id="customer_name" name="customer_name" type="text" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <div class="form-group">
                <label for="customer_email">Email</label>
                <input id="customer_email" name="customer_email" type="email" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone</label>
                <input id="customer_phone" name="customer_phone" type="text" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <h3 style="margin: 1.5rem 0 0.75rem; color: #1f2937;">Delivery Details</h3>

            <div class="form-group">
                <label for="item_description">Item Description</label>
                <textarea id="item_description" name="item_description" rows="3" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;">
            </div>

            <div class="form-group">
                <label for="pickup_address">Pickup Address</label>
                <textarea id="pickup_address" name="pickup_address" rows="3" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <div class="form-group">
                <label for="delivery_address">Delivery Address</label>
                <textarea id="delivery_address" name="delivery_address" rows="4" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
            </div>

            <button type="submit" class="btn">Submit Order</button>
        </form>

        <?php if (empty($approvedCompanies ?? [])): ?>
            <p style="margin-top: 1rem; color: #9ca3af;">
                No approved logistics companies are available yet.
            </p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>