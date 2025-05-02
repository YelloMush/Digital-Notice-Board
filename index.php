<?php
include 'db.php';

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($search) {
    $query = "SELECT * FROM notices 
              WHERE title LIKE '%$search%' OR description LIKE '%$search%' 
              ORDER BY posted_at DESC";
} else {
    $query = "SELECT * FROM notices ORDER BY posted_at DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Digital Notice Board</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-img-top {
      height: 220px;
      object-fit: cover;
      border-bottom: 1px solid #ddd;
    }
    .new-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #dc3545;
      color: white;
      font-size: 0.8rem;
      padding: 4px 7px;
      border-radius: 6px;
    }
    .position-relative {
      position: relative;
    }
    .hero {
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: white;
      padding: 60px 20px;
      text-align: center;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .footer {
      background-color: #f8f9fa;
      padding: 20px;
      text-align: center;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="#">Digisnare® Technologies</a>
    <a href="login.php" class="btn btn-outline-light ms-auto">Admin Login</a>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1>Welcome to the Digital Notice Board</h1>
    <p class="lead mt-3">Stay updated with the latest announcements, events, and updates — all in one place.</p>
  </div>
</section>

<!-- Search -->
<div class="container my-5">
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="search" class="form-control form-control-lg" placeholder="Search notices..." value="<?= htmlspecialchars($search) ?>">
      <button class="btn btn-primary btn-lg" type="submit">Search</button>
    </div>
  </form>

  <!-- Notices Grid -->
  <div class="row">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <?php
        $image = !empty($row['image']) ? 'uploads/' . $row['image'] : 'uploads/placeholder.jpg';
        $posted_at = strtotime($row['posted_at']);
        $isNew = (time() - $posted_at) <= (1 * 24 * 60 * 60); // within 2 days
      ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="position-relative">
            <img src="<?= $image ?>" class="card-img-top" alt="Notice Image">
            <?php if ($isNew): ?>
              <span class="new-badge">New</span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="card-text text-muted"><?= nl2br(htmlspecialchars(substr($row['description'], 0, 150))) ?>...</p>
          </div>
          <div class="card-footer bg-white border-top-0">
            <span class="badge bg-secondary"><?= htmlspecialchars($row['category']) ?></span>
            <span class="float-end text-muted small">Expires: <?= htmlspecialchars($row['expire_at']) ?></span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  &copy; <?= date("Y") ?> Digisnare® Technologies | Built using PHP & Bootstrap
</div>

</body>
</html>
