<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 'admin') {
    die("Access denied. Only the admin can view audit logs.");
}

include 'db.php';

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = '';
if ($start_date && $end_date) {
    $where = "WHERE timestamp BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
}

$query = "SELECT * FROM audit_log $where ORDER BY timestamp DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching logs: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Audit Log - Admin Only</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f1f3f5;
    }
    .container {
      margin-top: 50px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
    .card-header {
      background-color: #343a40;
      color: #fff;
      border-radius: 12px 12px 0 0;
    }
    .btn-primary {
      background-color: #0d6efd;
    }
    .badge-action {
      font-size: 0.9em;
      padding: 5px 10px;
    }
    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">⬅ Admin Dashboard</a>
    <a class="btn btn-outline-light" href="logout.php">Logout</a>
  </div>
</nav>

<div class="container">
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0">📝 Audit Log</h4>
    </div>
    <div class="card-body">

      <!-- Date Filter Form -->
      <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control">
        </div>
        <div class="col-md-4">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control">
        </div>
        <div class="col-md-4 align-self-end">
          <button type="submit" class="btn btn-primary w-100">🔎 Filter Logs</button>
        </div>
      </form>

      <!-- Audit Log Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-dark text-center">
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Action</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="text-center"><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td>
                    <span class="badge bg-info text-dark badge-action">
                      <?= htmlspecialchars($row['action']) ?>
                    </span>
                  </td>
                  <td><?= $row['timestamp'] ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted">No logs found for selected dates.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
