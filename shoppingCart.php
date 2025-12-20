<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$discountPercent = 0;
$discountAmount = 0.0;

if (isset($_POST['update_qty'])) {
    $pid = $_POST['pid'];
    $_SESSION['cart'][$pid]['quantity'] = max(1, (int)$_POST['quantity']);
}

if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][$_POST['pid']]);
}

if (isset($_POST['place_order'])) {

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '') {
        $_SESSION['redirect_after_login'] = 'shoppingCart.php';
        header('Location: login.php');
        exit;
    }

    $customersFile = __DIR__ . '/customers.json';
    $customers = file_exists($customersFile)
        ? json_decode(file_get_contents($customersFile), true)
        : [];

    $isBlocked = false;
    foreach ($customers as $c) {
        if (($c['Email'] ?? '') === $_SESSION['user_id'] && !empty($c['blocked'])) {
            $isBlocked = true;
            break;
        }
    }

    if ($isBlocked) {
        $orderError = "Your account is blocked by the administrator.";
    } elseif (empty($_SESSION['cart'])) {
        $orderError = "Your cart is empty.";
    } else {

        $ordersFile = __DIR__ . "/orders.json";

        if (!file_exists($ordersFile)) {
            file_put_contents($ordersFile, "[]");
        }

        $orders = json_decode(file_get_contents($ordersFile), true);
        if (!is_array($orders)) {
            $orders = [];
        }

        // ===== TASK 3: DISCOUNT LOGIC =====
        $userOrderCount = 0;
        foreach ($orders as $o) {
            if (($o['user'] ?? '') === $_SESSION['user_id']) {
                $userOrderCount++;
            }
        }

        $currentOrderNumber = $userOrderCount + 1;

        if ($currentOrderNumber % 20 === 0) {
            $discountPercent = 20;
        } elseif ($currentOrderNumber % 10 === 0) {
            $discountPercent = 10;
        }
        // =================================

        $items = [];
        $subtotal = 0.0;

        foreach ($_SESSION['cart'] as $item) {
            $unitPrice = (float)$item['price'];
            $quantity  = (int)$item['quantity'];
            $itemTotal = $unitPrice * $quantity;

            $items[] = [
                "pid" => $item['pid'],
                "name" => $item['name'],
                "unit_price" => number_format($unitPrice, 2, '.', ''),
                "quantity" => $quantity,
                "price" => number_format($itemTotal, 2, '.', '')
            ];

            $subtotal += $itemTotal;
        }

        $tax = $subtotal * 0.20;
        $totalBeforeDiscount = $subtotal + $tax;

        $discountAmount = ($totalBeforeDiscount * $discountPercent) / 100;
        $total = $totalBeforeDiscount - $discountAmount;

        $newOrder = [
            "order_id" => uniqid('ord_'),
            "user" => $_SESSION['user_id'],
            "date" => date("Y-m-d H:i:s"),
            "status" => "new",
            "admin_comment" => "",
            "order_number" => $currentOrderNumber,
            "discount_percent" => $discountPercent,
            "discount_amount" => number_format($discountAmount, 2, '.', ''),
            "subtotal" => number_format($subtotal, 2, '.', ''),
            "tax" => number_format($tax, 2, '.', ''),
            "total" => number_format($total, 2, '.', ''),
            "items" => $items
        ];

        $orders[] = $newOrder;

        file_put_contents(
            $ordersFile,
            json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );

        $_SESSION['cart'] = [];
        $orderSuccess = "Order placed successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 align="center">Shopping Cart</h1>

<?php if (!empty($orderSuccess)): ?>
    <p style="color: green; text-align: center; font-weight: bold;">
        <?= $orderSuccess ?>
    </p>
<?php endif; ?>

<?php if (!empty($orderError)): ?>
    <p style="color: red; text-align: center; font-weight: bold;">
        <?= $orderError ?>
    </p>
<?php endif; ?>

<?php if (empty($_SESSION['cart'])): ?>
    <center><h2>SHOPPING CART IS EMPTY</h2></center>
<?php else: ?>

<table border="1" align="center" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Unit Price (€)</th>
    <th>Quantity</th> 
    <th>Total (€)</th>
    <th>Remove</th> 
</tr>

<?php
$displaySubtotal = 0.0;
foreach ($_SESSION['cart'] as $pid => $item):
    $unitPrice = (float)$item['price'];
    $rowTotal  = $unitPrice * (int)$item['quantity'];
    $displaySubtotal += $rowTotal;
?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td><?= number_format($unitPrice, 2) ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="pid" value="<?= $pid ?>">
            <input type="hidden" name="update_qty" value="1">
            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" onchange="this.form.submit()">
        </form>
    </td>
    <td><?= number_format($rowTotal, 2) ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="pid" value="<?= $pid ?>">
            <input type="hidden" name="remove" value="1">
            <button type="submit">✖</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php
$displayTax = $displaySubtotal * 0.20;
$displayTotal = $displaySubtotal + $displayTax;
?>

<center>
    <p>Subtotal: €<?= number_format($displaySubtotal, 2) ?></p>
    <p>Tax (20%): €<?= number_format($displayTax, 2) ?></p>
    <h3>Total: €<?= number_format($displayTotal, 2) ?></h3>

    <form method="post">
        <input type="hidden" name="place_order" value="1">
        <button type="submit">Place Order</button>
    </form>
</center>

<?php endif; ?>

</body>
</html>
