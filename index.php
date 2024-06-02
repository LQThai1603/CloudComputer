<?php
include '../inc/dbinfo.inc';
include '/var/www/html/includes/header.php';
include 'config/config.php';
// Xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute(['id' => $id]);
    header('Location: index.php');
}

// Lấy tất cả sản phẩm
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();

// Tính tổng số lượng hàng có trong kho
$total_quantity = 0;
foreach ($products as $product) {
    $total_quantity += $product['quantity'];
}
?>

<h2>Product List</h2>
<a href="add-update/add_product.php" class="button">Add New Product</a>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td>
                <a class="button update" href="add-update/update_product.php?id=<?php echo $product['id']; ?>">Update</a>
                <a class="button delete" href="index.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Total Quantity: <?php echo $total_quantity; ?></h3>

<?php include 'includes/footer.php'; ?>