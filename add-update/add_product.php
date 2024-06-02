<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Warehouse Management</h1>
        </div>
    </header>
    <div class="container">

<?php
include '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];

    if ($quantity < 0) {
        $error = "Quantity cannot be less than 0.";
    } else {
        $stmt = $pdo->prepare('INSERT INTO products (name, quantity) VALUES (:name, :quantity)');
        $stmt->execute(['name' => $name, 'quantity' => $quantity]);

        header('Location: ../index.php');
    }
}
?>

<h2>Add Product</h2>
<a href="../index.php" class="button">Back to Product List</a>
<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required>
    <br>
    <input type="submit" value="Add Product">
</form>

<?php include '../includes/footer.php'; ?>