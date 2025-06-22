<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BINA | Reset Password</title>

    {{-- Custom Favicon --}}
    <link rel="icon" href="{{ asset('favicon-client.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon-client.png') }}" type="image/png">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-section.png') }}') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    margin: 0;
    padding: 15px;
}

.reset-card {
    width: 100%;
    max-width: 360px;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
}

.back-link {
    position: absolute;
    top: 1rem;
    left: 1rem;
    color: #64748b;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    text-decoration: none;
    font-size: 0.875rem;
}

.back-link:hover {
    color: #ff9900;
    transform: translateX(-2px);
}

.back-link i {
    margin-right: 0.25rem;
}

.logo-container {
    text-align: center;
    margin-bottom: 1.5rem;
    margin-top: 2rem;
}

.logo-container h4 {
    color: #1e293b;
    font-size: 1.5rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.logo-container p {
    color: #64748b;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.25rem;
    display: block;
    color: #1e293b;
    font-size: 0.875rem;
}

.form-control {
    padding: 0.625rem 0.875rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background-color: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.form-control:focus {
    box-shadow: 0 0 0 2px rgba(255, 153, 0, 0.25);
    border-color: #ff9900;
    background-color: #fff;
    outline: none;
}

.btn-reset {
    padding: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #ff9900;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: white;
    font-size: 0.875rem;
}

.btn-reset:hover {
    background-color: #ff9900;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.alert {
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.1);
    border-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
}

@media (max-width: 576px) {
    .reset-card {
        padding: 1.25rem;
    }
}
</style>

<div class="reset-card">
    <a href="{{ route('client.login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back to Login
    </a>
    <div class="logo-container">
        <h4>Reset Password</h4>
        <p>Enter your email address and we'll send you a link to reset your password.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Enter your email" required autofocus>
        </div>
        <button type="submit" class="btn btn-reset w-100">
            <i class="bi bi-envelope me-1"></i>Send Reset Link
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide success alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
</body>
</html> 