<?php
include 'db.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = "WHERE 1";

if ($search) {
    $escapedSearch = mysqli_real_escape_string($conn, $search);
    $where .= " AND (title LIKE '%$escapedSearch%' OR description LIKE '%$escapedSearch%')";
}

if ($start_date && $end_date) {
    $where .= " AND posted_at BETWEEN '$start_date' AND '$end_date'";
}

$query = "SELECT * FROM notices $where ORDER BY posted_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Digital Notice Board</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
    }
    .hero {
      background: linear-gradient(120deg, #1e3c72, #2a5298);
      color: white;
      padding: 70px 0;
      text-align: center;
    }
    .hero h1 {
      font-size: 3.2rem;
      font-weight: 700;
    }
    .hero p {
      font-size: 1.2rem;
      margin-top: 10px;
    }
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      border-radius: 16px;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .card-img-top {
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
    }
    .new-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #dc3545;
      color: white;
      font-size: 0.75rem;
      padding: 5px 8px;
      border-radius: 8px;
      font-weight: bold;
    }
    .position-relative {
      position: relative;
    }
    .filter-form input,
    .filter-form button {
      border-radius: 8px;
    }
    .footer {
      background-color: #212529;
      color: white;
      padding: 25px 0;
      text-align: center;
      font-size: 0.9rem;
      margin-top: 60px;
    }
    .badge.bg-secondary {
      background-color: #6c757d !important;
    }
    .clear-btn {
      background-color: #6c757d;
      border: none;
    }
    .clear-btn:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container px-4">
    <a class="navbar-brand" href="#">Digisnare® Technologies</a>
    <a href="login.php" class="btn btn-outline-light ms-auto">Admin Login</a>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1>Digital Notice Board</h1>
    <p class="lead">Stay informed with the latest updates, announcements & events — all in one place.</p>
  </div>
</section>

<!-- Filter Section -->
<div class="container my-5">
  <form method="GET" class="row g-3 mb-4 filter-form">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control form-control-lg" placeholder="Search notices..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-3">
      <input type="date" name="start_date" class="form-control form-control-lg" value="<?= htmlspecialchars($start_date) ?>">
    </div>
    <div class="col-md-3">
      <input type="date" name="end_date" class="form-control form-control-lg" value="<?= htmlspecialchars($end_date) ?>">
    </div>
    <div class="col-md-1 d-grid">
      <button class="btn btn-primary btn-lg" type="submit">Filter</button>
    </div>
    <div class="col-md-1 d-grid">
      <a href="index.php" class="btn clear-btn btn-lg text-white">Clear</a>
    </div>
  </form>

  <!-- Notices Grid -->
  <div class="row">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <?php
        $image = !empty($row['image']) ? 'uploads/' . $row['image'] : 'uploads/placeholder.jpg';
        $posted_at = strtotime($row['posted_at']);
        $isNew = (time() - $posted_at) <= (2 * 24 * 60 * 60); // within 2 days
      ?>
      <div class="col-md-4 mb-4">
        <a href="notice_view.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm">
            <div class="position-relative">
              <img src="<?= $image ?>" class="card-img-top" alt="Notice Image">
              <?php if ($isNew): ?>
                <span class="new-badge">New</span>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
              <p class="card-text text-muted"><?= nl2br(htmlspecialchars(substr($row['description'], 0, 120))) ?>...</p>
            </div>
            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
              <span class="badge bg-secondary"><?= htmlspecialchars($row['category']) ?></span>
              <small class="text-muted">Expires: <?= htmlspecialchars($row['expire_at']) ?></small>
            </div>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  &copy; <?= date("Y") ?> Digisnare® Technologies | Built with ❤️ using PHP & Bootstrap
</div>

</body>
</html>
