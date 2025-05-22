<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Auto-expire notices whose date has passed
mysqli_query($conn, "UPDATE notices SET status = 'expired' WHERE expire_at < NOW() AND status = 'active'");

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = "WHERE 1";
if ($start_date && $end_date) {
    $where .= " AND posted_at BETWEEN '$start_date' AND '$end_date'";
}

$query = "SELECT id, title, posted_at, expire_at, created_by, status FROM notices $where ORDER BY posted_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar {
      background-color: #0d1b2a;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 1.2rem;
    }

    .container {
      margin-top: 50px;
    }

    .form-label {
      font-weight: 500;
    }

    h3.welcome-message {
      margin-bottom: 30px;
      font-weight: 600;
      color: #333;
    }

    .btn-create {
      padding: 10px 20px;
      font-weight: 500;
      margin-right: 10px;
    }

    .table {
      border-radius: 8px;
      overflow: hidden;
      background-color: #ffffff;
    }

    .table th {
      background-color: #343a40;
      color: #fff;
      text-align: center;
      font-weight: 600;
    }

    .table td {
      vertical-align: middle;
    }

    .actions-btns a {
      margin: 0 5px;
    }

    .table-responsive {
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border-radius: 8px;
      overflow: hidden;
    }

    .filter-card {
      padding: 20px;
      border-radius: 10px;
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .btn-primary, .btn-success, .btn-secondary {
      border-radius: 8px;
    }

    .btn-sm {
      padding: 5px 10px;
    }

    .badge-status {
      padding: 5px 10px;
      font-size: 0.85rem;
      border-radius: 12px;
    }

    .badge-active {
      background-color: #198754;
    }

    .badge-expired {
      background-color: #dc3545;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Dashboard | Digisnare® Technologies</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container">

    <h3 class="welcome-message">Welcome, <?= htmlspecialchars($_SESSION['admin']) ?></h3>

    <div class="filter-card">
      <form method="GET" class="row g-3">
        <div class="col-md-4">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control">
        </div>
        <div class="col-md-4">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control">
        </div>
        <div class="col-md-4 align-self-end">
          <button type="submit" class="btn btn-primary w-100">Filter Notices</button>
        </div>
      </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <a href="create_notice.php" class="btn btn-success btn-create">+ Create New Notice</a>
        <?php if ($_SESSION['admin'] === 'admin'): ?>
          <a href="audit_log.php" class="btn btn-secondary btn-create">📋 View Audit Log</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Posted On</th>
            <th>Expires</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td class="text-center"><?= $row['id'] ?></td>
                <td>
                  <a href="notice_view.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark fw-semibold">
                    <?= htmlspecialchars($row['title']) ?>
                  </a>
                </td>

                <td><?= $row['posted_at'] ?></td>
                <td><?= $row['expire_at'] ?></td>
                <td><?= htmlspecialchars($row['created_by']) ?></td>
                <td class="text-center">
                  <span class="badge badge-status <?= $row['status'] === 'active' ? 'badge-active' : 'badge-expired' ?>">
                    <?= ucfirst($row['status']) ?>
                  </span>
                </td>
                <td class="text-center actions-btns">
                  <a href="edit_notice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="delete_notice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center">No notices available.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
