<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BINA | Register</title>

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
    color: #ff9900;
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
    box-shadow: 0 0 0 2px rgba(255, 153, 0, 0.25);
    border-color: #ff9900;
    background-color: #fff;
    outline: none;
}

.btn-login {
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

.btn-login:hover {
    background-color: #ff9900;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    color:white;
}

.alert {
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.875rem;
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

.btn-social.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.btn-social img {
    height: 20px;
}

.login-link {
    text-align: center;
    margin-top: 1rem;
    color: #64748b;
    font-size: 0.875rem;
}

.login-link a {
    color: #ff9900;
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 576px) {
    .login-card {
        padding: 1.25rem;
    }
}

.error-list {
    list-style-type: none;
    padding-left: 0;
    margin-bottom: 0;
}

.error-list li {
    color: #dc3545;
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.error-list li:before {
    content: "•";
    position: absolute;
    left: 0.5rem;
}

.error-list li:last-child {
    margin-bottom: 0;
}

.form-text ul {
    padding-left: 1.2rem;
    margin-top: 0.5rem;
}

.form-text ul li {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.modal-header {
    padding: 1.5rem 1.5rem 0.5rem;
    text-align: center;
    display: block;
}

.modal-header .modal-title {
    font-size: 1.25rem;
    font-weight: 600;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 0.5rem 1.5rem 1.5rem;
}

.modal-footer .btn {
    padding: 0.75rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.modal-footer .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

/* Tooltip Styles */
.tooltip {
    font-size: 0.75rem;
}

.tooltip-inner {
    max-width: 300px;
    padding: 0.5rem 1rem;
    text-align: left;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.tooltip-inner br {
    margin-bottom: 0.25rem;
}

/* Password Toggle Button */
.input-group .btn-outline-secondary {
    border-color: #e2e8f0;
    color: #64748b;
    padding: 0.625rem;
    background-color: white;
}

.input-group .btn-outline-secondary:hover {
    background-color: #f8fafc;
    color: #1e293b;
}

.input-group .btn-outline-secondary:focus {
    box-shadow: none;
}

.input-group .form-control:focus + .btn-outline-secondary {
    border-color: #ff9900;
}
</style>

<div class="login-card">
    <a href="{{ route('client.home') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
    <div class="logo-container">
        <h4>Create Account</h4>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
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

    <form id="registerForm" method="POST" action="{{ route('client.register.submit') }}">
        @csrf
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Enter your username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       placeholder="Create a password" 
                       required
                       data-bs-toggle="tooltip"
                       data-bs-html="true"
                       data-bs-trigger="focus"
                       title="Password must:<br>• Be at least 8 characters long<br>• Include at least one uppercase letter<br>• Include at least one lowercase letter<br>• Include at least one number<br>• Include at least one special character (@$!%*?&)">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-group">
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Confirm your password" 
                       required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100">Sign Up</button>
    </form>

    <div class="social-login">
        <div class="divider">
            <span>Or sign up with</span>
        </div>
        <div class="social-buttons" style="display: flex; justify-content: center;">
            <a href="{{ route('auth.google') }}" class="btn-social">
                <img src="https://www.google.com/favicon.ico" alt="Google">
            </a>
            {{-- Commented out until implementation
            <a class="btn-social disabled" title="Coming soon">
                <img src="https://www.facebook.com/favicon.ico" alt="Facebook">
            </a>
            <a class="btn-social disabled" title="Coming soon">
                <img src="https://www.linkedin.com/favicon.ico" alt="LinkedIn">
            </a>
            --}}
    </div>

    <div class="login-link">
        Already have an account? <a href="{{ route('client.login') }}">Sign in</a>
    </div>
</div>

<!-- Response Modal -->
<div class="modal fade" id="responseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="responseModalLabel">Registration Status</h5>
            </div>
            <div class="modal-body">
                <div id="modalIcon" class="text-center mb-3">
                    <!-- Icon will be inserted here -->
                </div>
                <div id="modalMessage" class="text-center mb-0"></div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-lg w-100" id="modalActionButton">Continue</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));
        
        // Function to show response in modal
        function showResponseModal(success, message, redirect = null) {
            $('#modalIcon').html(
                success 
                ? '<i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>'
                : '<i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>'
            );
            $('#modalMessage').html(message);
            $('#modalActionButton')
                .text(success ? 'Continue' : 'Try Again')
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

        // Check for response data in session
        @if (session('auth_response'))
            const response = @json(session('auth_response'));
            showResponseModal(response.success, response.message, response.redirect);
        @endif

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
            });
        });

        // Toggle password visibility
        $('#togglePassword').click(function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        $('#toggleConfirmPassword').click(function() {
            const confirmPasswordInput = $('#password_confirmation');
            const icon = $(this).find('i');
            
            if (confirmPasswordInput.attr('type') === 'password') {
                confirmPasswordInput.attr('type', 'text');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                confirmPasswordInput.attr('type', 'password');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        // Regular registration form handling
        $('#registerForm').on('submit', function(e) {
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
                    let errorMessage = 'An error occurred during registration.';
                    
                    if (response.errors) {
                        errorMessage = '<ul class="error-list">';
                        Object.values(response.errors).forEach(function(error) {
                            errorMessage += '<li>' + error + '</li>';
                        });
                        errorMessage += '</ul>';
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