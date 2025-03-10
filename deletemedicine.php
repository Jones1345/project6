<?php
session_start();
include "db.php";
include "auth.php";

check_role(["pharmacist"]);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $conn->query("DELETE FROM medicines WHERE id='$id'");
}

header("Location: manage_medicinesphar.php");
exit;
?>