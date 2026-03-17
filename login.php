<?php
if (isset($_POST['login'])) {
    include 'db.php';
    if(!isset($_SESSION)) session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hardcoded default user check
    if ($email === 'admin' && $password === 'admin') {
        $_SESSION['user'] = $email;
        
        // Check if there are items in the cart to decide redirect
        $cart_check = $conn->query("SELECT id FROM cart LIMIT 1");
        if ($cart_check->num_rows > 0) {
            header("Location: checkout.php");
        } else {
            header("Location: products.php");
        }
        exit();
    }

    // Secure login check using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $email;
        
        // Check if there are items in the cart to decide redirect
        $cart_check = $conn->query("SELECT id FROM cart LIMIT 1");
        if ($cart_check->num_rows > 0) {
            header("Location: checkout.php");
        } else {
            header("Location: products.php");
        }
        exit();
    } else {
        $msg = "Invalid Email or Password";
    }
}
include 'header.php';
?>

<div class="login-container">
    <h2 align="center" style="color: #0a7a2f; margin-bottom: 30px;">Login to Your Account</h2>

    <?php if (isset($msg)): ?>
        <p style="color: #ff4d4d; background: #fff5f5; padding: 10px; border-radius: 5px; text-align: center; border: 1px solid #ffebeb; margin-bottom: 20px;">
            <?php echo $msg; ?>
        </p>
    <?php endif; ?>

    <form method="post">
        <label style="font-size: 14px; font-weight: 600; color: #666; display: block; margin-bottom: 8px;">Username / Email</label>
        <input type="text" name="email" placeholder="Enter your email" required>
        
        <label style="font-size: 14px; font-weight: 600; color: #666; display: block; margin-bottom: 8px;">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
        
        <button type="submit" name="login">Login Now</button>
        <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
            Don't have an account? <a href="register.php" style="color: #0a7a2f; font-weight: 600; text-decoration: none;">Register here</a>
        </p>
    </form>
</div>

</body>
</html>