<?php
include('db.php');
session_start();

$id = intval($_GET['id']);
$query = "SELECT * FROM notices WHERE id = $id AND is_deleted = 0";
$result = mysqli_query($conn, $query);
$notice = mysqli_fetch_assoc($result);

if (!$notice) {
    echo "<div style='padding: 2rem; font-family: sans-serif;'>Notice not found or has been deleted.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($notice['title']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1e1e2f; /* Dark grey background */
      color: #f0f0f0; /* Light text for contrast */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .notice-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 30px;
      background: #2b2b3d; /* Slightly lighter dark for contrast */
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .notice-image {
      max-height: 400px;
      object-fit: cover;
      border-radius: 8px;
    }

    .label {
      font-weight: 600;
      color: #bbbbbb;
    }

    .btn-secondary {
      background-color: #444c56;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #5a6270;
    }
  </style>
</head>
<body>

<div class="notice-container">
  <h2 class="mb-4"><?= htmlspecialchars($notice['title']) ?></h2>

  <?php if (!empty($notice['image'])): ?>
    <img src="uploads/<?= $notice['image'] ?>" class="img-fluid notice-image mb-4" alt="Notice Image">
  <?php endif; ?>

  <p class="mb-3"><span class="label">Description:</span><br> <?= nl2br(htmlspecialchars($notice['description'])) ?></p>
  <p><span class="label">Category:</span> <?= htmlspecialchars($notice['category']) ?></p>
  <p><span class="label">Created by:</span> <?= htmlspecialchars($notice['created_by']) ?></p>
  <p><span class="label">Posted on:</span> <?= $notice['posted_at'] ?></p>
  <p><span class="label">Expires on:</span> <?= $notice['expire_at'] ?></p>

  <a href="index.php" class="btn btn-secondary mt-4">← Back to Home</a>
  <a href="generate_pdf.php?id=<?= $notice['id'] ?>" class="btn btn-secondary mt-4">📄 Download PDF</a>

</div>

</body>
</html>
