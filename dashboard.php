<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include 'db.php';

$query = "SELECT id, title, posted_at, expire_at FROM notices";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar {
      border-bottom: 2px solid #ccc;
    }
    .table {
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .btn-create {
      font-size: 1.1rem;
      padding: 10px 20px;
    }
    .container {
      margin-top: 30px;
    }
    .table th {
      text-align: center;
    }
    .actions-btns a {
      margin: 0 5px;
    }
    .welcome-message {
      color: #333;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Dashboard</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <h3 class="welcome-message">Welcome, Admin!</h3>
    <div class="mb-4 text-right">
      <a href="create_notice.php" class="btn btn-success btn-create">+ Create New Notice</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Posted On</th>
            <th>Expires</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td class='text-center'>" . $row['id'] . "</td>";
              echo "<td>" . $row['title'] . "</td>";
              echo "<td>" . $row['posted_at'] . "</td>";
              echo "<td>" . $row['expire_at'] . "</td>";
              echo "<td class='actions-btns text-center'>
                      <a href='edit_notice.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                      <a href='delete_notice.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5' class='text-center'>No notices available</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
