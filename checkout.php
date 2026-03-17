<?php
include 'db.php';
if(!isset($_SESSION)) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Handle order booking
if (isset($_POST['book_order'])) {
    $user_email = $_SESSION['user'];

    // Fetch current cart items to save into orders table
    $cart_items = $conn->query("SELECT products.product_name, products.price, cart.quantity 
                                FROM cart 
                                JOIN products ON cart.product_id = products.id");

    if ($cart_items->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO orders (user_email, product_name, price, quantity) VALUES (?, ?, ?, ?)");
        while ($item = $cart_items->fetch_assoc()) {
            $stmt->bind_param("ssdi", $user_email, $item['product_name'], $item['price'], $item['quantity']);
            $stmt->execute();
        }
    }

    // Clear the cart
    $conn->query("DELETE FROM cart");
    header("Location: order.php");
    exit();
}

include 'header.php';

$sql = "SELECT products.product_name, products.price, cart.id, cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id";
$result = $conn->query($sql);
$total = 0;
?>

<div style="max-width: 600px; margin: 40px auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
    <h2 style="color: #0a7a2f; border-bottom: 2px solid #eee; padding-bottom: 10px;">Order Summary</h2>
    
    <div style="margin: 20px 0;">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): 
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
            ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span><?php echo $row['product_name']; ?> (x<?php echo $row['quantity']; ?>)</span>
                    <span>₹<?php echo number_format($subtotal, 2); ?></span>
                </div>
            <?php endwhile; ?>
            
            <div style="display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee; font-size: 24px; font-weight: bold;">
                <span>Total</span>
                <span style="color: #0a7a2f;">₹<?php echo number_format($total, 2); ?></span>
            </div>

            <form method="post" style="margin-top: 30px;">
                <button type="submit" name="book_order" style="width: 100%; background: #FFD700; color: #333; padding: 15px; border: none; border-radius: 30px; font-weight: bold; cursor: pointer; font-size: 18px;">Confirm & Book Order</button>
            </form>
        <?php else: ?>
            <p>No items to checkout. <a href="products.php">Back to products</a></p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>