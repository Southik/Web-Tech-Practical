<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin1@example.com') {
    die('Access denied.');
}

$ordersFile    = __DIR__ . '/orders.json';
$customersFile = __DIR__ . '/customers.json';

$orders = file_exists($ordersFile)
    ? json_decode(file_get_contents($ordersFile), true)
    : [];
if (!is_array($orders)) $orders = [];

foreach ($orders as $idx => &$o) {
    $o['order_id']      = $o['order_id']      ?? ('ord_' . $idx);
    $o['status']        = $o['status']        ?? 'new';
    $o['admin_comment'] = $o['admin_comment'] ?? '';
}
unset($o);

$customers = file_exists($customersFile)
    ? json_decode(file_get_contents($customersFile), true)
    : [];
if (!is_array($customers)) $customers = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['order_id'], $_POST['action'])) {
        $orderId = $_POST['order_id'];
        $action  = $_POST['action'];
        $comment = $_POST['comment'] ?? '';

        foreach ($orders as &$o) {
            if ($o['order_id'] === $orderId) {
                if ($action === 'processing') {
                    $o['status'] = 'processing';
                } elseif ($action === 'shipped') {
                    $o['status'] = 'shipped';
                } elseif ($action === 'finished') {
                    $o['status'] = 'finished';
                } elseif ($action === 'rejected') {
                    $o['status']        = 'rejected';
                    $o['admin_comment'] = $comment;
                }
            }
        }
        unset($o);

        file_put_contents(
            $ordersFile,
            json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    if (isset($_POST['customer_email'], $_POST['customer_action'])) {
        $email  = $_POST['customer_email'];
        $cAct   = $_POST['customer_action'];

        foreach ($customers as &$c) {
            if (($c['Email'] ?? '') === $email) {
                if ($cAct === 'block') {
                    $c['blocked'] = true;
                } elseif ($cAct === 'unblock') {
                    $c['blocked'] = false;
                }
            }
        }
        unset($c);

        file_put_contents(
            $customersFile,
            json_encode($customers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    $view = $_GET['view'] ?? 'all';
    header('Location: adminOrders.php?view=' . urlencode($view));
    exit;
}

$view = $_GET['view'] ?? 'new'; 
$filtered = array_filter($orders, function($o) use ($view) {
    if ($view === 'all') return true;
    return ($o['status'] ?? 'new') === $view;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
	<a href="logout.php"> 
		<button type="button" class="logout-button">Logout</button>
	</a>
</nav>
<h1>Admin Orders</h1>

<p>
    View:
    <a href="?view=new">New</a> |
    <a href="?view=processing">Processing</a> |
    <a href="?view=shipped">Shipped</a> |
    <a href="?view=finished">Finished</a> |
    <a href="?view=rejected">Rejected</a> |
    <a href="?view=all">All</a>
</p>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Total (€)</th>
        <th>Status</th>
        <th>Admin comment</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($filtered as $o): ?>
        <tr>
            <td><?= htmlspecialchars($o['order_id']) ?></td>
            <td><?= htmlspecialchars($o['user'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['date'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['total'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['status']) ?></td>
            <td><?= htmlspecialchars($o['admin_comment']) ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($o['order_id']) ?>">
                    <button name="action" value="processing">Processing</button>
                    <button name="action" value="shipped">Shipped</button>
                    <button name="action" value="finished">Finished</button>
                </form>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($o['order_id']) ?>">
                    <input type="text" name="comment" placeholder="Reject reason">
                    <button name="action" value="rejected">Reject</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Customers</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Email</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['Email'] ?? '') ?></td>
            <td><?= htmlspecialchars(($c['Firstname'] ?? '').' '.($c['Lastname'] ?? '')) ?></td>
            <td><?= !empty($c['blocked']) ? 'Blocked' : 'Active' ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="customer_email" value="<?= htmlspecialchars($c['Email'] ?? '') ?>">
                    <?php if (!empty($c['blocked'])): ?>
                        <button name="customer_action" value="unblock">Unblock</button>
                    <?php else: ?>
                        <button name="customer_action" value="block">Block</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
