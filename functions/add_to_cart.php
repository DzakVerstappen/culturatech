<?php
include 'database_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $userId = null; // Update dengan sistem login jika ada
    $quantity = 1;

    if (addToCart($productId, $userId, $quantity)) {
        header("Location: cart.php");
    } else {
        echo "Gagal menambahkan ke keranjang.";
    }
}
?>
