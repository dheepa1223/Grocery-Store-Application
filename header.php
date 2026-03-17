<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GroceryStore - Fresh & Fast</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="navbar">
    <h2>GroceryStore</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart 
            <span id="cart-count" style="background: #ff4d4d; color: white; padding: 2px 8px; border-radius: 50%; font-size: 12px; font-weight: 600; margin-left: 5px;">
                <?php
                $cart_query = $conn->query("SELECT SUM(quantity) as total FROM cart");
                $cart_data = $cart_query->fetch_assoc();
                echo $cart_data['total'] ? $cart_data['total'] : 0;
                ?>
            </span>
        </a>
        <?php 
        if(!isset($_SESSION)) session_start();
        if(isset($_SESSION['user'])): ?>
            <?php if($_SESSION['user'] === 'admin'): ?>
                <a href="admin_orders.php" style="color: #0a7a2f; font-weight: 800;">All Orders (Admin)</a>
            <?php endif; ?>
            <a href="my_orders.php">My Orders</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>