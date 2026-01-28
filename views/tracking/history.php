<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Results - My Order Fellow</title>
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
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: #ffffff;
            padding: 1.5rem 2rem;
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
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
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .status-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .tracking-number {
            font-size: 0.875rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .tracking-id {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
        }

        .current-status-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
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

        .timeline-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .timeline-card h2 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0.5rem;
            bottom: 0.5rem;
            width: 2px;
            background-color: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.75rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            background-color: #9ca3af;
            border-radius: 50%;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 2px #e5e7eb;
        }

        .timeline-item.latest::before {
            background-color: #16a34a;
            width: 16px;
            height: 16px;
            left: -1.85rem;
            box-shadow: 0 0 0 3px #dcfce7;
        }

        .timeline-date {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .timeline-status {
            margin-bottom: 0.25rem;
        }

        .timeline-status .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.75rem;
        }

        .timeline-description {
            font-size: 0.9rem;
            color: #4b5563;
            margin-top: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-state p {
            font-size: 1rem;
            font-style: italic;
        }

        .btn-back {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.3);
        }

        .action-section {
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <h1>My Order Fellow</h1>
            <a href="/track">&larr; Track Another</a>
        </div>
    </header>

    <main class="container">
        <!-- Status Overview Card -->
        <div class="status-card">
            <div class="tracking-number">Tracking Number</div>
            <div class="tracking-id"><?= htmlspecialchars($order['external_order_id'] ?? '') ?></div>

            <div class="current-status-label">Current Status</div>
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
        </div>

        <!-- Timeline Card -->
        <div class="timeline-card">
            <h2>Shipment History</h2>

            <?php if (empty($history)): ?>
                <div class="empty-state">
                    <p>No tracking updates available yet.</p>
                </div>
            <?php else: ?>
                <div class="timeline">
                    <?php foreach ($history as $index => $event): ?>
                        <div class="timeline-item <?= $index === 0 ? 'latest' : '' ?>">
                            <div class="timeline-date">
                                <?= htmlspecialchars($event['created_at'] ?? '') ?>
                            </div>
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
                                <div class="timeline-description">
                                    <?= htmlspecialchars($event['description']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <a href="/track" class="btn-back">Track Another Package</a>
        </div>
    </main>
</body>

</html>