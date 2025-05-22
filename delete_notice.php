<?php
session_start(); // ✅ REQUIRED to access $_SESSION
include('db.php');  

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    // Optional: Fetch the title for better logs
    $title = 'Unknown';
    $result = mysqli_query($conn, "SELECT title FROM notices WHERE id = $id");
    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
    }

    // Delete the notice
    $query = "DELETE FROM notices WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // Prepare audit log
        $user = $_SESSION['admin'];
        $log = "$user deleted notice titled '$title' (ID $id)";
        $log = mysqli_real_escape_string($conn, $log); // Escape special characters
        mysqli_query($conn, "INSERT INTO audit_log (username, action) VALUES ('$user', '$log')");
    }
}

header("Location: dashboard.php");
exit();
?>
