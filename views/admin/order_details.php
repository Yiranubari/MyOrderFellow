<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin Panel - My Order Fellow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
        }

        .header {
            background-color: #1e3a5f;
            color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .header a {
            color: #ffffff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 1px solid #ffffff;
            border-radius: 4px;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }

        .header a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .back-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #6b7280;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background-color: #4b5563;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .card h2 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            color: #1f2937;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-in-transit {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .badge-out-for-delivery {
            background-color: #ede9fe;
            color: #7c3aed;
        }

        .badge-delivered {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-group select,
        .form-group input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.875rem;
            color: #1f2937;
            background-color: #ffffff;
        }

        .form-group select:focus,
        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 2px rgba(30, 58, 95, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #1e3a5f;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #163352;
        }

        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.25rem;
            top: 0.25rem;
            width: 10px;
            height: 10px;
            background-color: #6b7280;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .timeline-item.latest::before {
            background-color: #1e3a5f;
            width: 12px;
            height: 12px;
            left: -1.3rem;
        }

        .timeline-date {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .timeline-status {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .timeline-description {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: #6b7280;
        }

        .empty-state p {
            font-size: 0.875rem;
            font-style: italic;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>Admin Panel - My Order Fellow</h1>
        <a href="/admin/logout">Logout</a>
    </header>

    <main class="container">
        <a href="/admin/orders" class="back-btn">&larr; Back to Orders</a>

        <div class="grid">
            <!-- Left Column: Order Information -->
            <div class="card">
                <h2>Order Information</h2>

                <div class="info-row">
                    <span class="info-label">Internal ID</span>
                    <span class="info-value"><?= htmlspecialchars($order['id'] ?? '') ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">External Ref</span>
                    <span class="info-value"><?= htmlspecialchars($order['external_order_id'] ?? '') ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Customer Email</span>
                    <span class="info-value"><?= htmlspecialchars($order['customer_email'] ?? '') ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Current Status</span>
                    <span class="info-value">
                        <?php
                        $status = strtoupper($order['status'] ?? '');
                        $badgeClass = 'badge ';

                        if ($status === 'PENDING') {
                            $badgeClass .= 'badge-pending';
                        } elseif ($status === 'IN TRANSIT') {
                            $badgeClass .= 'badge-in-transit';
                        } elseif ($status === 'OUT FOR DELIVERY') {
                            $badgeClass .= 'badge-out-for-delivery';
                        } elseif ($status === 'DELIVERED') {
                            $badgeClass .= 'badge-delivered';
                        }
                        ?>
                        <span class="<?= $badgeClass ?>"><?= htmlspecialchars($order['status'] ?? '') ?></span>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Created At</span>
                    <span class="info-value"><?= htmlspecialchars($order['created_at'] ?? '') ?></span>
                </div>

                <!-- Update Status Form -->
                <h2 style="margin-top: 1.5rem;">Update Status</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="status">New Status</label>
                        <select name="status" id="status" required>
                            <option value="PENDING" <?= ($order['status'] ?? '') === 'PENDING' ? 'selected' : '' ?>>
                                PENDING</option>
                            <option value="IN TRANSIT"
                                <?= ($order['status'] ?? '') === 'IN TRANSIT' ? 'selected' : '' ?>>IN TRANSIT</option>
                            <option value="OUT FOR DELIVERY"
                                <?= ($order['status'] ?? '') === 'OUT FOR DELIVERY' ? 'selected' : '' ?>>OUT FOR
                                DELIVERY</option>
                            <option value="DELIVERED" <?= ($order['status'] ?? '') === 'DELIVERED' ? 'selected' : '' ?>>
                                DELIVERED</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="note">Note (optional)</label>
                        <input type="text" name="note" id="note" placeholder="e.g., Arrived at local hub">
                    </div>

                    <button type="submit" class="btn-submit">Update Status</button>
                </form>
            </div>

            <!-- Right Column: Timeline -->
            <div class="card">
                <h2>Tracking History</h2>

                <?php if (empty($history)): ?>
                    <div class="empty-state">
                        <p>No tracking history available.</p>
                    </div>
                <?php else: ?>
                    <div class="timeline">
                        <?php foreach ($history as $index => $event): ?>
                            <div class="timeline-item <?= $index === 0 ? 'latest' : '' ?>">
                                <div class="timeline-date"><?= htmlspecialchars($event['created_at'] ?? '') ?></div>
                                <div class="timeline-status">
                                    <?php
                                    $eventStatus = strtoupper($event['status'] ?? '');
                                    $eventBadgeClass = 'badge ';

                                    if ($eventStatus === 'PENDING') {
                                        $eventBadgeClass .= 'badge-pending';
                                    } elseif ($eventStatus === 'IN TRANSIT') {
                                        $eventBadgeClass .= 'badge-in-transit';
                                    } elseif ($eventStatus === 'OUT FOR DELIVERY') {
                                        $eventBadgeClass .= 'badge-out-for-delivery';
                                    } elseif ($eventStatus === 'DELIVERED') {
                                        $eventBadgeClass .= 'badge-delivered';
                                    }
                                    ?>
                                    <span class="<?= $eventBadgeClass ?>"><?= htmlspecialchars($event['status'] ?? '') ?></span>
                                </div>
                                <?php if (!empty($event['description'])): ?>
                                    <div class="timeline-description"><?= htmlspecialchars($event['description']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>