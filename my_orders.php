<?php
include 'header.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$sql = "SELECT * FROM orders WHERE user_email = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<div style="padding: 40px 10%;">
    <h2 style="font-size: 36px; color: #0a7a2f; text-align: center; margin-bottom: 30px;">Order History</h2>

    <?php if ($result->num_rows > 0): ?>
        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <thead>
                <tr style="background: #0a7a2f; color: white; text-align: left;">
                    <th style="padding: 15px;">Order ID</th>
                    <th style="padding: 15px;">Product</th>
                    <th style="padding: 15px;">Price</th>
                    <th style="padding: 15px;">Quantity</th>
                    <th style="padding: 15px;">Total</th>
                    <th style="padding: 15px;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">#<?php echo $row['id']; ?></td>
                        <td style="padding: 15px; font-weight: 600;"><?php echo $row['product_name']; ?></td>
                        <td style="padding: 15px;">₹<?php echo number_format($row['price'], 2); ?></td>
                        <td style="padding: 15px;"><?php echo $row['quantity']; ?></td>
                        <td style="padding: 15px; font-weight: bold; color: #0a7a2f;">₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                        <td style="padding: 15px; color: #666; font-size: 14px;"><?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <p style="color: #666; font-size: 18px;">You haven't placed any orders yet.</p>
            <a href="products.php" class="btn" style="display: inline-block; margin-top: 20px;">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
