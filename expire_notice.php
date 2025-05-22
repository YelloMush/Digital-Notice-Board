<?php
include('db.php');

// Update notices that have expired
$query = "UPDATE notices SET status = 'expired' WHERE expire_at < NOW() AND status = 'active'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Expired notices updated successfully.";
} else {
    echo "Error updating expired notices: " . mysqli_error($conn);
}
?>
