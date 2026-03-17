<?php
include 'db.php';

if (isset($_POST['register'])) {
    if(!isset($_SESSION)) session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $msg = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msg = "Email already registered!";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);
            
            if ($stmt->execute()) {
                $success_msg = "Registration successful! You can now login.";
                // Optional: redirect to login after a delay or just show links
            } else {
                $msg = "Error: Could not register user.";
            }
        }
    }
}
include 'header.php';
?>

<div class="login-container">
    <h2 align="center" style="color: #0a7a2f; margin-bottom: 30px;">Create Your Account</h2>

    <?php if (isset($msg)): ?>
        <p style="color: #ff4d4d; background: #fff5f5; padding: 10px; border-radius: 5px; text-align: center; border: 1px solid #ffebeb; margin-bottom: 20px;">
            <?php echo $msg; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($success_msg)): ?>
        <p style="color: #0a7a2f; background: #f0fff4; padding: 10px; border-radius: 5px; text-align: center; border: 1px solid #c6f6d5; margin-bottom: 20px;">
            <?php echo $success_msg; ?>
        </p>
        <div style="text-align: center;">
            <a href="login.php" class="checkout-btn" style="display: inline-block; width: auto; padding: 10px 30px; margin-top: 10px;">Go to Login</a>
        </div>
    <?php else: ?>
        <form method="post">
            <label style="font-size: 14px; font-weight: 600; color: #666; display: block; margin-bottom: 8px;">Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            
            <label style="font-size: 14px; font-weight: 600; color: #666; display: block; margin-bottom: 8px;">Password</label>
            <input type="password" name="password" placeholder="Create a password" required>

            <label style="font-size: 14px; font-weight: 600; color: #666; display: block; margin-bottom: 8px;">Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            
            <button type="submit" name="register">Register Now</button>
            <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
                Already have an account? <a href="login.php" style="color: #0a7a2f; font-weight: 600; text-decoration: none;">Login here</a>
            </p>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
