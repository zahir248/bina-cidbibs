<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BINA | Login</title>

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

.login-card {
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
    color: #0d6efd;
    transform: translateX(-2px);
}

.back-link i {
    margin-right: 0.25rem;
}

.logo-container {
    text-align: center;
    margin-bottom: 1.5rem;
    margin-top: 1rem;
}

.logo-container img {
    height: 40px;
    margin-bottom: 0.5rem;
}

.logo-container h4 {
    color: #1e293b;
    font-size: 1.5rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
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
    box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
    border-color: #0d6efd;
    background-color: #fff;
}

.btn-login {
    padding: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #0d6efd;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: white;
    font-size: 0.875rem;
}

.btn-login:hover {
    background-color: #0b5ed7;
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

.social-login {
    margin-top: 1.25rem;
    text-align: center;
}

.social-login .divider {
    display: flex;
    align-items: center;
    margin: 0.75rem 0;
}

.social-login .divider::before,
.social-login .divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e2e8f0;
}

.social-login .divider span {
    padding: 0 0.75rem;
    color: #64748b;
    font-size: 0.75rem;
}

.social-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.btn-social {
    padding: 0.5rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: white;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-social:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-social img {
    height: 20px;
}

.btn-social.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.register-link {
    text-align: center;
    margin-top: 1rem;
    color: #64748b;
    font-size: 0.875rem;
}

.register-link a {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 600;
}

.register-link a:hover {
    text-decoration: underline;
}

@media (max-width: 576px) {
    .login-card {
        padding: 1.25rem;
    }
}
</style>

<div class="login-card">
    <a href="{{ route('client.home') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
    <div class="logo-container">
        <h4>Welcome Back</h4>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
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

    <form id="loginForm" method="POST" action="{{ route('client.login.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" 
                   placeholder="Enter your password" required>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <a href="#" class="text-decoration-none">Forgot?</a>
        </div>
        <button type="submit" class="btn btn-login w-100">Sign In</button>
    </form>

    <div class="social-login">
        <div class="divider">
            <span>Or continue with</span>
        </div>
        <div class="social-buttons">
            <a href="{{ route('auth.google') }}" class="btn-social">
                <img src="https://www.google.com/favicon.ico" alt="Google">
            </a>
            <a class="btn-social disabled" title="Coming soon">
                <img src="https://www.facebook.com/favicon.ico" alt="Facebook">
            </a>
            <a class="btn-social disabled" title="Coming soon">
                <img src="https://www.linkedin.com/favicon.ico" alt="LinkedIn">
            </a>
        </div>
    </div>

    <div class="register-link">
        New user? <a href="{{ route('client.register') }}">Sign up</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));
        
        // Keep remember me checkbox always checked
        $('#remember').prop('checked', true).on('click', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Function to show response in modal
        function showResponseModal(success, message, redirect = null) {
            $('#modalIcon').html(
                success 
                ? '<i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>'
                : '<i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>'
            );
            $('#modalMessage').html(message);
            $('#modalActionButton')
                .text(success ? 'Continue to Home' : 'Try Again')
                .removeClass(success ? 'btn-danger' : 'btn-success')
                .addClass(success ? 'btn-success' : 'btn-danger')
                .off('click')
                .on('click', function() {
                    if (success && redirect) {
                        window.location.href = redirect;
                    } else {
                        responseModal.hide();
                        if (!success) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 200);
                        }
                    }
                });
            responseModal.show();
        }

        // Handle Google authentication response
        if (window.location.href.includes('auth/google/callback')) {
            $.ajax({
                url: window.location.href,
                method: 'GET',
                success: function(response) {
                    showResponseModal(true, response.message, response.redirect);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    showResponseModal(false, response.message || 'An error occurred during Google login.');
                }
            });
        }

        // Regular login form handling
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    showResponseModal(true, response.message, response.redirect);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    let errorMessage = 'An error occurred during login.';
                    
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    } else if (response.message) {
                        errorMessage = response.message;
                    }
                    
                    showResponseModal(false, errorMessage);
                }
            });
        });
    });
</script>
</body>
</html>