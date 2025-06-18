<style>
:root {
    --bina-orange: #ff9900;
}

body {
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.navbar {
    transition: transform 0.3s ease-in-out;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background-color: var(--bina-orange) !important;
    transform: translateY(-100%);
}

.navbar.navbar-visible {
    transform: translateY(0);
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
    color: var(--bina-orange) !important;
}

/* Add spacing between nav items */
.navbar .nav-item {
    margin: 0 0.75rem;
    padding: 0.25rem 0;
}

.navbar .nav-link {
    padding: 0.5rem 1rem !important;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.3s ease;
    color: white !important;
}

.nav-link.active,
.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    font-weight: bold;
}

/* Override Bootstrap's default navbar-light styles */
.navbar.navbar-light .navbar-nav .nav-link {
    color: white !important;
}

.navbar.navbar-light .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.navbar.navbar-light .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.5);
}

.dropdown-menu {
    background-color: white !important;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    color: #333 !important;
    transition: all 0.3s ease;
}

.dropdown-item:hover,
.dropdown-item:focus {
    background-color: rgba(0, 0, 0, 0.05) !important;
    color: #333 !important;
}

.dropdown-item.active,
.dropdown-item.fw-bold {
    background-color: rgba(255, 153, 0, 0.1) !important;
    color: var(--bina-orange) !important;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .navbar .nav-item {
        margin: 0.5rem 0;
    }
    
    .navbar .nav-link {
        padding: 0.75rem 1.25rem !important;
    }
}

.btn-orange {
    background-color: var(--bina-orange);
    color: white;
}

.btn-orange:hover {
    background-color: #e08000;
    color: white;
}

.btn-orange-outline {
    border: 1px solid var(--bina-orange);
    color: var(--bina-orange);
}

.btn-orange-outline:hover {
    background-color: var(--bina-orange);
    color: white;
}

/* Main content padding for fixed navbar */
main {
    padding-top: 76px;
}

/* Footer Styles */
.footer {
    background-color: #e67e00;  /* Darker shade of orange */
    color: #ffffff;
    padding: 60px 0 20px;
}

.footer-logo {
    height: 50px;
    width: auto;
    filter: brightness(0) invert(1);
}

.company-info p {
    color: white;
    font-size: 14px;
    font-weight: 500;
}

.social-links {
    margin-top: 20px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-right: 10px;
    color: white !important;
    transition: all 0.3s ease;
    text-decoration: none !important;
}

.social-link:hover {
    background-color: white;
    color: var(--bina-orange) !important;
    transform: translateY(-2px);
    text-decoration: none !important;
}

.footer h5 {
    color: white;
    font-weight: bold;
}

.text-orange {
    color: white !important;
}

.contact-info p {
    color: white;
    font-size: 14px;
    font-weight: 500;
}

.contact-info a {
    color: white !important;
    text-decoration: none !important;
    font-weight: bold;
}

.contact-info a:hover {
    opacity: 0.8;
}

.newsletter-form {
    width: 100%;
}

.newsletter-form input {
    background-color: rgba(255, 255, 255, 0.2) !important;
    border: none;
    color: white !important;
    padding: 10px 15px;
}

.newsletter-form input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Prevent browser autofill styling */
.newsletter-form input:-webkit-autofill,
.newsletter-form input:-webkit-autofill:hover,
.newsletter-form input:-webkit-autofill:focus,
.newsletter-form input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px rgba(255, 255, 255, 0.2) inset !important;
    -webkit-text-fill-color: white !important;
    transition: background-color 5000s ease-in-out 0s;
}

.newsletter-form input:focus {
    outline: none;
    box-shadow: none;
    background-color: rgba(255, 255, 255, 0.2) !important;
}

.newsletter-form .btn-orange {
    background-color: white;
    color: var(--bina-orange);
    border: none;
    padding: 10px 20px;
    font-weight: bold;
}

.newsletter-form .btn-orange:hover {
    background-color: rgba(255, 255, 255, 0.9);
}

.partner-logos {
    margin-top: 30px;
    width: 100%;
    display: flex;
    justify-content: flex-start;
}

.partner-logo {
    width: 100%;
    height: auto;
    filter: brightness(0) invert(1);
    object-fit: contain;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 20px;
    color: white;
    font-size: 14px;
    font-weight: 500;
}

.footer a {
    text-decoration: none !important;
}

/* Card Styles */
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    main {
        padding-top: 60px;
    }
}
</style> 