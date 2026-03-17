<?php
include 'header.php';

// Only allow 'admin' user to access this page
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    echo "<div style='text-align:center; padding:50px; color:red;'>
            <h2>Access Denied</h2>
            <p>You do not have permission to view this page.</p>
            <a href='index.php'>Go Home</a>
          </div>";
    exit();
}

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<div style="padding: 40px 10%;">
    <h2 style="font-size: 36px; color: #0a7a2f; text-align: center; margin-bottom: 30px;">Admin - All Customer Orders</h2>

    <?php if ($result->num_rows > 0): ?>
        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <thead>
                <tr style="background: #333; color: white; text-align: left;">
                    <th style="padding: 15px;">Order ID</th>
                    <th style="padding: 15px;">Customer Email</th>
                    <th style="padding: 15px;">Product</th>
                    <th style="padding: 15px;">Price</th>
                    <th style="padding: 15px;">Qty</th>
                    <th style="padding: 15px;">Total</th>
                    <th style="padding: 15px;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">#<?php echo $row['id']; ?></td>
                        <td style="padding: 15px; color: #0a7a2f; font-weight: 600;"><?php echo $row['user_email']; ?></td>
                        <td style="padding: 15px;"><?php echo $row['product_name']; ?></td>
                        <td style="padding: 15px;">₹<?php echo number_format($row['price'], 2); ?></td>
                        <td style="padding: 15px;"><?php echo $row['quantity']; ?></td>
                        <td style="padding: 15px; font-weight: bold;">₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                        <td style="padding: 15px; color: #666; font-size: 14px;"><?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: #666; font-size: 18px;">No orders have been placed yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
