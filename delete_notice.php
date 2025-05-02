<?php
include('db.php');  

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM notices WHERE id = $id";
    mysqli_query($conn, $query);
}

header("Location: dashboard.php");
exit();
?>
