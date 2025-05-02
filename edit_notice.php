<?php
// Database connection
include 'db.php';

// Get the notice ID from the URL
$notice_id = $_GET['id'];

// Fetch the notice from the database based on the ID
$query = "SELECT * FROM notices WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $notice_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the notice exists
if ($result->num_rows > 0) {
    $notice = $result->fetch_assoc();
} else {
    // Handle case where the notice doesn't exist
    echo "Notice not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Notice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Edit Notice</h2>
    <form method="POST" action="update_notice.php?id=<?= $notice['id'] ?>">
      <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($notice['title']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($notice['description']) ?></textarea>
      </div>
      <div class="mb-3">
        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($notice['category']) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Expiry Date</label>
        <input type="date" name="expire_at" value="<?= htmlspecialchars($notice['expire_at']) ?>" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Update Notice</button>
      <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
