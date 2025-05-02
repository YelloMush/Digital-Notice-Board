<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $cat = $_POST['category'];
    $exp = $_POST['expire_at'];

    $query = "UPDATE notices SET title=?, description=?, category=?, expire_at=? WHERE id=?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $title, $desc, $cat, $exp, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error executing query: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }
}
?>
