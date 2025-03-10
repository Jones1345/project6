<?php
session_start();
include "db.php";
include "auth.php";
check_role(["pharmacist"]);


// Handle form submission to add medicine
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_medicine"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $expiry_date = $_POST["expiry_date"];
    
    // Image upload
    $image = "default.jpg";
    if (!empty($_FILES["image"]["name"])) {
        $image = time() . "_" . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }

    $query = "INSERT INTO medicines (name, price, stock, expiry_date, image) VALUES ('$name', '$price', '$stock', '$expiry_date', '$image')";
    $conn->query($query);
}

// Fetch all medicines
$medicines = $conn->query("SELECT * FROM medicines");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="manage_medicines.css">
</head>
<body>
<h2>Manage Medicines</h2>
<a href="pharmacist_home.php">⬅ Back to Pharmacist Dashboard</a><br><br>

<!-- Form to Add Medicine -->
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Medicine Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <input type="date" name="expiry_date" required>
    <input type="file" name="image">
    <button type="submit" name="add_medicine">Add Medicine</button>
</form>

<!-- Display Existing Medicines -->
<h3>Existing Medicines</h3>
<table border="1">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Expiry Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $medicines->fetch_assoc()): ?>
        <tr>
            <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="50"></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td>$<?= htmlspecialchars($row["price"]) ?></td>
            <td><?= htmlspecialchars($row["stock"]) ?></td>
            <td><?= htmlspecialchars($row["expiry_date"]) ?></td>
            <td>
                <a href="edit_medicine copy.php?id=<?= $row['id'] ?>">✏ Edit</a> | 
                <a href="deletemedicine.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?');">❌ Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>