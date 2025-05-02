<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Notice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-publish {
      font-size: 1.1rem;
      padding: 12px 30px;
      width: 100%;
    }
    .btn-back {
      font-size: 1.1rem;
      padding: 12px 30px;
      width: 100%;
      margin-top: 10px;
    }
    .form-label {
      font-weight: bold;
    }
    h2 {
      margin-bottom: 20px;
      color: #333;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Create New Notice</h2>
    <form method="POST" action="save_notice.php" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Notice Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" name="category" id="category" class="form-control">
      </div>
      <div class="mb-3">
        <label for="expire_at" class="form-label">Expiry Date</label>
        <input type="date" name="expire_at" id="expire_at" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success btn-publish">Publish Notice</button>
      <a href="dashboard.php" class="btn btn-secondary btn-back">Back</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
