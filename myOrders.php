<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$ordersFile = __DIR__ . '/orders.json';
$orders = file_exists($ordersFile)
    ? json_decode(file_get_contents($ordersFile), true)
    : [];
if (!is_array($orders)) $orders = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $orderId = $_POST['order_id'] ?? '';
    foreach ($orders as &$o) {
        if (($o['order_id'] ?? '') === $orderId && ($o['user'] ?? '') === $_SESSION['user_id']) {
            $status = $o['status'] ?? 'new';
            if ($status === 'new' || $status === 'ordered') {
                $o['status'] = 'canceled';
            }
        }
    }
    unset($o);
    file_put_contents(
        $ordersFile,
        json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}

$customerOrders = [];
foreach ($orders as $idx => $o) {
    if (($o['user'] ?? '') !== $_SESSION['user_id']) continue;

    $o['status']        = $o['status']        ?? 'new';
    $o['admin_comment'] = $o['admin_comment'] ?? '';
    $o['order_id']      = $o['order_id']      ?? ('legacy_' . $idx);
    $customerOrders[]   = $o;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
	<a href="logout.php"> 
		<button type="button" class="logout-button">Logout</button>
    </a>
</nav>
<h1>My Orders</h1>

<?php if (empty($customerOrders)): ?>
    <p>You have no orders yet.</p>
<?php else: ?>
<table border="1" cellpadding="8">
    <tr>
        <th>Date</th>
        <th>Total (€)</th>
        <th>Status</th>
        <th>Admin comment</th>
        <th>Action</th>
    </tr>
    <?php foreach ($customerOrders as $o): ?>
        <tr>
            <td><?= htmlspecialchars($o['date'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['total'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['status']) ?></td>
            <td><?= htmlspecialchars($o['admin_comment']) ?></td>
            <td>
                <?php if ($o['status'] === 'new' || $o['status'] === 'ordered'): ?>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($o['order_id']) ?>">
                        <button type="submit" name="cancel_order" value="1">Cancel</button>
                    </form>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>
