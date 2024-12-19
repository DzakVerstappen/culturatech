<?php
include 'database_functions.php';

global $connection;
$userId = null; // Update dengan sistem login jika ada
$query = "SELECT cart.quantity, products.product_name, products.product_price 
          FROM cart 
          INNER JOIN products ON cart.product_id = products.product_id
          WHERE cart.user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <table border="1">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= htmlspecialchars($row['product_price']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
