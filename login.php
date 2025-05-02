<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border: 2px solid #003366; /* Darker blue border */
      border-radius: 10px;
    }
    .card-header {
      background-color: #003366; /* Darker blue background */
    }
    .card-header h4 {
      margin: 0;
      font-weight: bold;
    }
    .btn-login {
      background-color: #00509E; /* Custom dark blue */
      color: white;
      font-size: 1.1rem;
      padding: 12px 20px;
      border: none;
      width: 100%;
    }
    .btn-login:hover {
      background-color: #003366; /* Darker blue on hover */
    }
    .card-body {
      padding: 30px;
    }
    .form-label {
      font-weight: bold;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header text-white text-center">
            <h4>Admin Login</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="authenticate.php">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-login">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
