<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - My Order Fellow</title>
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

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .actions form {
            display: inline;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-approve {
            background-color: #16a34a;
            color: #ffffff;
        }

        .btn-reject {
            background-color: #dc2626;
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

    <main class="container">
        <div class="card">
            <h2>Pending KYC Applications</h2>

            <?php if (empty($pendingCompanies)): ?>
                <div class="empty-state">
                    <p>No pending applications at this time.</p>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Business Reg No</th>
                                <th>Address</th>
                                <th>Contact Person</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingCompanies as $company): ?>
                                <tr>
                                    <td><?= htmlspecialchars($company['company_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($company['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($company['business_reg_no'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($company['business_address'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($company['contact_person'] ?? '') ?></td>
                                    <td class="actions">
                                        <form method="POST" action="/admin/approve">
                                            <input type="hidden" name="company_id"
                                                value="<?= htmlspecialchars($company['id'] ?? '') ?>">
                                            <button type="submit" class="btn btn-approve">Approve</button>
                                        </form>
                                        <form method="POST" action="/admin/reject">
                                            <input type="hidden" name="company_id"
                                                value="<?= htmlspecialchars($company['id'] ?? '') ?>">
                                            <button type="submit" class="btn btn-reject">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>