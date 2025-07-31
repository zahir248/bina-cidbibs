<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Lookup - BINA</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-client.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-client.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon-client.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Simple Header -->
<nav class="simple-header">
    <div class="container">
        <div class="header-content">
            <a href="{{ route('client.home') }}" class="logo-link">
                <img src="{{ asset('images/bina-logo.png') }}" alt="BINA Logo" class="header-logo">
            </a>
            <a href="{{ route('client.home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Main Site
            </a>
        </div>
    </div>
</nav>

<div class="order-lookup-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="order-lookup-card">
                    <div class="order-lookup-header">
                        <h1>Order Lookup</h1>
                        <p>Enter your Identity Card Number/Passport and email address to access your order confirmation and tickets.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('client.order-lookup.process') }}" class="order-lookup-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="identity_number">Identity Card Number / Passport <span class="required">*</span></label>
                            <input type="text" 
                                   class="form-control @error('identity_number') is-invalid @enderror" 
                                   id="identity_number" 
                                   name="identity_number" 
                                   value="{{ old('identity_number') }}" 
                                   placeholder="e.g. 880101015432" 
                                   required>
                            <small class="form-text text-muted">
                                Use the same Identity Card Number/Passport you provided during checkout
                            </small>
                            @error('identity_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="e.g. john@company.com" 
                                   required>
                            <small class="form-text text-muted">
                                Use the same email address you provided during checkout
                            </small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Look Up Order
                            </button>
                        </div>
                    </form>

                    <div class="order-lookup-info">
                        <h4>Need Help?</h4>
                        <ul>
                            <li>Use the same Identity Card Number/Passport you provided during checkout</li>
                            <li>If you used a company email, you can still access your order here</li>
                            <li>Make sure to use the exact email address you provided during checkout</li>
                            <li>Only paid orders can be accessed through this lookup</li>
                        </ul>
                        
                        <div class="mt-3">
                            <p><strong>Don't have an account?</strong></p>
                            <a href="{{ route('client.register') }}" class="btn btn-outline-primary">Create Account</a>
                            <span class="mx-2">or</span>
                            <a href="{{ route('client.login') }}" class="btn btn-outline-secondary">Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Header Styles */
.simple-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 1rem 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo-link {
    text-decoration: none;
}

.header-logo {
    height: 40px;
    width: auto;
}

.back-link {
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #2980b9;
    text-decoration: none;
}

.order-lookup-container {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.order-lookup-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 40px;
    margin-top: 20px;
}

.order-lookup-header {
    text-align: center;
    margin-bottom: 30px;
}

.order-lookup-header h1 {
    color: #2c3e50;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.order-lookup-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
    margin: 0;
}

.order-lookup-form {
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    display: block;
}

.required {
    color: #e74c3c;
}

.form-control {
    border: 2px solid #ecf0f1;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.form-control.is-invalid {
    border-color: #e74c3c;
}

.invalid-feedback {
    color: #e74c3c;
    font-size: 0.875rem;
    margin-top: 5px;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
}

.btn-block {
    width: 100%;
}

.order-lookup-info {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 25px;
    border-left: 4px solid #3498db;
}

.order-lookup-info h4 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 600;
}

.order-lookup-info ul {
    padding-left: 20px;
    margin-bottom: 20px;
}

.order-lookup-info li {
    color: #5a6c7d;
    margin-bottom: 8px;
    line-height: 1.5;
}

.btn-outline-primary {
    border-color: #3498db;
    color: #3498db;
    border-radius: 6px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #3498db;
    border-color: #3498db;
    color: white;
}

.btn-outline-secondary {
    border-color: #95a5a6;
    color: #95a5a6;
    border-radius: 6px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #95a5a6;
    border-color: #95a5a6;
    color: white;
}

@media (max-width: 768px) {
    .simple-header {
        padding: 0.75rem 0;
    }
    
    .header-logo {
        height: 35px;
    }
    
    .back-link {
        font-size: 0.9rem;
    }
    
    .order-lookup-container {
        padding: 40px 0;
    }
    
    .order-lookup-card {
        padding: 30px 20px;
        margin: 10px;
    }
    
    .order-lookup-header h1 {
        font-size: 2rem;
    }
}
</style>
</body>
</html> 