<?php
include 'header.php';
if(!isset($_SESSION)) session_start();
// Optionally clear session cart if it was still in use
unset($_SESSION['cart']);
?>

<div style="text-align: center; padding: 80px 20px;">
    <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
    <h2 style="color: #0a7a2f; font-size: 40px; margin-bottom: 15px;">Order Placed Successfully!</h2>
    <p style="color: #666; font-size: 18px; max-width: 600px; margin: 0 auto 40px;">Your fresh groceries are being packed and will reach you shortly. Thank you for shopping with GroceryStore.</p>
    
    <a href="index.php" class="btn">Continue Shopping</a>
</div>

</body>
</html>