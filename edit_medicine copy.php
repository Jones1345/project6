<?php
session_start();
include "db.php";
include "auth.php";

check_role(["pharmacist"] );


if (!isset($_GET["id"])) {
    header("Location: manage_medicinesphar.php");
    exit;
}

$id = $_GET["id"];
$medicine = $conn->query("SELECT * FROM medicines WHERE id = '$id'")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $expiry_date = $_POST["expiry_date"];

    $update_query = "UPDATE medicines SET name='$name', price='$price', stock='$stock', expiry_date='$expiry_date' WHERE id='$id'";
    $conn->query($update_query);

    header("Location: manage_medicinesphar.php");
    exit;
}
?>

<h2>Edit Medicine</h2>
<form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($medicine["name"]) ?>" required>
    <input type="number" name="price" value="<?= htmlspecialchars($medicine["price"]) ?>" required>
    <input type="number" name="stock" value="<?= htmlspecialchars($medicine["stock"]) ?>" required>
    <input type="date" name="expiry_date" value="<?= htmlspecialchars($medicine["expiry_date"]) ?>" required>
    <button type="submit">Update Medicine</button>
</form>
<a href="manage_medicinesphar.php">⬅ Back</a>
