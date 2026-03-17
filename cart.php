<?php
include 'header.php';

$sql = "SELECT cart.id, products.product_name, products.price, cart.quantity, products.image 
        FROM cart 
        JOIN products ON cart.product_id = products.id";
$result = $conn->query($sql);
?>

<div style="padding: 40px 10%; text-align: center;">
    <h2 style="font-size: 36px; color: #0a7a2f;">Your Cart</h2>
</div>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
        ?>
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="<?php echo $row['image']; ?>" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;">
                        <?php echo $row['product_name']; ?>
                    </div>
                </td>
                <td>₹<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>₹<?php echo number_format($subtotal, 2); ?></td>
                <td><a href="cancel.php?id=<?php echo $row['id']; ?>" style="color: #ff4d4d; text-decoration: none; font-weight: bold;">Remove</a></td>
            </tr>
        <?php 
            endwhile;
        else:
        ?>
            <tr>
                <td colspan="5" style="text-align: center;">Your cart is empty. <a href="products.php">Shop now</a></td>
            </tr>
        <?php endif; ?>
    </tbody>
    <?php if ($total > 0): ?>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total</td>
            <td colspan="2" style="font-size: 20px; font-weight: bold; color: #0a7a2f;">₹<?php echo number_format($total, 2); ?></td>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>

<?php if ($total > 0): ?>
    <?php if (isset($_SESSION['user'])): ?>
        <a class="checkout-btn" href="checkout.php">Go to Checkout</a>
    <?php else: ?>
        <a class="checkout-btn" href="login.php" style="background: #666;">Login to Checkout</a>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>