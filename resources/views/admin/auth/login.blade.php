<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.login-card {
    width: 100%;
    max-width: 400px;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    background-color: #fff;
    margin: 15px;
}

.logo-container {
    text-align: center;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    border-color: #86b7fe;
}

.btn-login {
    padding: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,.1);
}

@media (max-width: 576px) {
    .login-card {
    padding: 1.25rem;
    }
}
</style>

<div class="login-card">
  <div class="logo-container">
    <h4 class="fw-bold">Admin</h4>
  </div>
  
  <form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="email" name="email" required 
             value="{{ old('email', 'admin@example.com') }}">
    </div>
    
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" required 
             value="1234">
    </div>
    
    <div class="d-grid">
      <button type="submit" class="btn btn-primary btn-login">Login</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>