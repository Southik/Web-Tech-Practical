<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* AUTO UPDATE QUANTITY */
if (isset($_POST['update_qty'])) {
    $_SESSION['cart'][$_POST['pid']]['quantity'] =
        max(1, (int)$_POST['quantity']);
}

/* REMOVE ITEM */
if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][$_POST['pid']]);
}

/* =============================
   PLACE ORDER (AUTH REQUIRED)
   ============================= */
if (isset($_POST['place_order'])) {

    if (
        !isset($_SESSION['user_id']) ||
        $_SESSION['user_id'] === ''
    ) {
        $_SESSION['redirect_after_login'] = 'shoppingCart.php';
        header("Location: login.php");
        exit;
    }

    // SAVE ORDER
    $order  = "User: " . $_SESSION['user_id'] . "\n";
    $order .= "Date: " . date("Y-m-d H:i:s") . "\n";

    foreach ($_SESSION['cart'] as $item) {
        $order .= $item['name'] . " x" . $item['quantity'] . "\n";
    }

    $order .= "-------------------------\n";
    file_put_contents("orders.txt", $order, FILE_APPEND);

    $_SESSION['cart'] = [];
    $orderSuccess = "Order placed successfully!";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 align="center">Shopping Cart</h1>

<?php if (!empty($orderSuccess)): ?>
<p style="color:green;text-align:center;font-weight:bold;">
    <?= $orderSuccess ?>
</p>
<?php endif; ?>

<?php if (empty($_SESSION['cart'])): ?>
    <center><h2>SHOPPING CART IS EMPTY</h2></center>
<?php else: ?>

<table border="1" align="center" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price (€)</th>
    <th>Quantity</th>
    <th>Total (€)</th>
    <th>Remove</th>
</tr>

<?php
$subtotal = 0;
foreach ($_SESSION['cart'] as $pid => $item):
    $itemTotal = $item['price'] * $item['quantity'];
    $subtotal += $itemTotal;
?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td><?= number_format($item['price'],2) ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="pid" value="<?= $pid ?>">
            <input type="hidden" name="update_qty" value="1">
            <input type="number"
                   name="quantity"
                   value="<?= $item['quantity'] ?>"
                   min="1"
                   onchange="this.form.submit()">
        </form>
    </td>
    <td><?= number_format($itemTotal,2) ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="pid" value="<?= $pid ?>">
            <button name="remove">✖</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php
$tax = $subtotal * 0.20;
$total = $subtotal + $tax;
?>

<center>
    <p>Subtotal: €<?= number_format($subtotal,2) ?></p>
    <p>Tax (20%): €<?= number_format($tax,2) ?></p>
    <h3>Total: €<?= number_format($total,2) ?></h3>

    <form method="post">
        <button name="place_order">Place Order</button>
    </form>
</center>

<?php endif; ?>

</body>
</html>
