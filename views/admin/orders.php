<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Panel - My Order Fellow</title>
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

        .layout {
            display: flex;
            min-height: calc(100vh - 60px);
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 1.5rem 0;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #f3f4f6;
            color: #1e3a5f;
            border-left: 3px solid #1e3a5f;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
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

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead tr {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 0.75rem;
            text-align: left;
            color: #374151;
            font-weight: 600;
        }

        td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-shipped,
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

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-manage {
            background-color: #1e3a5f;
            color: #ffffff;
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
    </style>
</head>

<body>
    <header class="header">
        <h1>Admin Panel - My Order Fellow</h1>
        <a href="/admin/logout">Logout</a>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <ul class="sidebar-nav">
                <li><a href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/orders" class="active">Orders</a></li>
                <li><a href="/admin/users">Users</a></li>
                <li><a href="/admin/settings">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="card">
                <h2>All Orders</h2>

                <?php if (empty($orders)): ?>
                    <div class="empty-state">
                        <p>No orders found.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Internal ID</th>
                                    <th>External Ref</th>
                                    <th>Customer Email</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($order['external_order_id'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($order['customer_email'] ?? '') ?></td>
                                        <td>
                                            <?php
                                            $status = strtolower($order['status'] ?? '');
                                            $badgeClass = 'badge ';

                                            if ($status === 'pending') {
                                                $badgeClass .= 'badge-pending';
                                            } elseif ($status === 'shipped' || $status === 'in transit') {
                                                $badgeClass .= 'badge-shipped';
                                            } elseif ($status === 'out for delivery') {
                                                $badgeClass .= 'badge-out-for-delivery';
                                            } elseif ($status === 'delivered') {
                                                $badgeClass .= 'badge-delivered';
                                            }
                                            ?>
                                            <span
                                                class="<?= $badgeClass ?>"><?= htmlspecialchars($order['status'] ?? '') ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($order['created_at'] ?? '') ?></td>
                                        <td>
                                            <a href="/admin/order/details?id=<?= htmlspecialchars($order['id'] ?? '') ?>"
                                                class="btn btn-manage">Manage</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>