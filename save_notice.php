<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $expire_at = $_POST['expire_at'];
    $created_by = $_SESSION['admin'];

    // Handle image upload
    $imageName = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $uploadPath = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
    }

    $status = 'active';  // New notices start as active

    $query = "INSERT INTO notices (title, description, category, expire_at, image, created_by, status)
            VALUES ('$title', '$description', '$category', '$expire_at', '$imageName', '$created_by', '$status')";


    if (mysqli_query($conn, $query)) {
        $user = $_SESSION['admin'];
        $log = "$user created a new notice titled '$title'";
        $log = mysqli_real_escape_string($conn, $log); // ✅ Escape the string
        mysqli_query($conn, "INSERT INTO audit_log (username, action) VALUES ('$user', '$log')");

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error creating notice: " . mysqli_error($conn);
    }
}




?>
