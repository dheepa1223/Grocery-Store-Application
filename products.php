<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'db.php';
    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = $data['id'];

    // Check if product already in cart
    $check = $conn->prepare("SELECT id, quantity FROM cart WHERE product_id = ?");
    $check->bind_param("i", $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_qty = $row['quantity'] + 1;
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
        $update->bind_param("ii", $new_qty, $product_id);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (product_id, quantity) VALUES (?, 1)");
        $insert->bind_param("i", $product_id);
        $insert->execute();
    }

    $total_res = $conn->query("SELECT SUM(quantity) as total FROM cart");
    $total_data = $total_res->fetch_assoc();
    $total_count = $total_data['total'] ? $total_data['total'] : 0;

    echo json_encode(["status" => "added", "total_count" => $total_count]);
    exit;
}

include 'header.php';


$products = $conn->query("SELECT * FROM products");
?>

<div style="padding: 40px 10%; text-align: center;">
    <h2 style="font-size: 36px; color: #0a7a2f;">Fresh Vegetables</h2>
    <p style="color: #666;">Quality products handpicked for you</p>
</div>

<div class="products">
    <?php while($p = $products->fetch_assoc()): ?>
        <div class="product">
            <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['product_name']; ?>">
            <h3><?php echo $p['product_name']; ?></h3>
            <p>₹<?php echo number_format($p['price'], 2); ?></p>
            <button onclick="addCart(<?php echo $p['id']; ?>)">Add to Cart</button>
        </div>
    <?php endwhile; ?>
</div>

<script>
function addCart(id) {
    fetch("products.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({id: id})
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "added") {
            const countBadge = document.getElementById("cart-count");
            if (countBadge) {
                countBadge.textContent = data.total_count;
            }
            alert("Product Added to Cart!");
        }
    })
    .catch(err => {
        console.error("Error adding to cart:", err);
        alert("Could not add product to cart. Please try again.");
    });
}
</script>

</body>
</html>